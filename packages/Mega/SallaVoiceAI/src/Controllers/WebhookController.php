<?php

namespace Mega\SallaVoiceAI\Controllers;

use App\Http\Controllers\Controller;
use Mega\SallaVoiceAI\Models\VoiceWebhook;
use Mega\SallaVoiceAI\Models\VoiceMerchant;
use App\Models\VoicePlanConfiguration;
use Mega\SallaVoiceAI\Services\Merchant\MerchantProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Psr\Log\LoggerInterface;

class WebhookController extends Controller
{
    private LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = Log::channel('salla_voice_ai');
    }

    public function index(Request $request)
    {
        $params = $request->all();
        try {
            $this->logger->info('voice webhook request: ' . json_encode($params));
            $webhook = VoiceWebhook::create([
                'event' => $params['event'] ?? null,
                'merchant' => $params['merchant'] ?? null,
                'status'  => 'success',
                'payload' => json_encode($params),
                'reference_number' => $params['data']['id'] ?? "-",
            ]);
        } catch (\Exception $e) {
            $this->logger->info($e->getMessage());
        }

        $event = $params['event'] ?? null;
        $resp = [];
        switch ($event) {
            case 'app.store.authorize':
                try {
                    $data['merchant_identifier'] = $params['merchant'] ?? null;
                    $data['access_token'] = $params['data']['access_token'] ?? null;
                    $data['refresh_token'] = $params['data']['refresh_token'] ?? null;
                    $expirationDate = Carbon::now()->addDays(13);
                    $data['token_exp'] = $expirationDate;
                    $merchant = VoiceMerchant::updateOrCreate(
                        ['merchant_identifier' => $params['merchant'] ?? null],
                        $data
                    );
                    $merchantProfileService = app(MerchantProfile::class);
                    $merchantProfileService->completeMerchantProfile($merchant);
                    $resp = [
                        'status' => true,
                        'data' => ['event' => 'authorized']
                    ];
                } catch (\Exception $e) {
                    $this->logger->info($e->getMessage());
                }
                break;

            case 'app.trial.started':
            case 'app.trial.renewed':
                try {
                    $merchantId = $params['merchant'] ?? null;
                    $subData = $params['data'] ?? [];
                    $endDate = $subData['end_date'] ?? null;

                    // Trial maps directly to the Free Plan configuration search limit
                    $planKey = 'free';
                    $monthlyLimit = class_exists(VoicePlanConfiguration::class)
                        ? VoicePlanConfiguration::getLimitForSlug('free')
                        : 100;

                    $resetAt = $endDate ? Carbon::parse($endDate) : Carbon::now()->addDays(7);

                    if ($merchantId) {
                        $merchant = VoiceMerchant::where('merchant_identifier', (string)$merchantId)->first();
                        if (!$merchant) {
                            $merchant = VoiceMerchant::where('store_reference', (string)$merchantId)->first();
                        }

                        if ($merchant) {
                            $merchant->update([
                                'plan' => $planKey,
                                'monthly_voice_limit' => $monthlyLimit,
                                'voice_usage_count' => 0,
                                'usage_reset_at' => $resetAt,
                            ]);
                        } else {
                            $merchant = VoiceMerchant::create([
                                'merchant_identifier' => (string)$merchantId,
                                'store_reference' => (string)$merchantId,
                                'plan' => $planKey,
                                'monthly_voice_limit' => $monthlyLimit,
                                'voice_usage_count' => 0,
                                'usage_reset_at' => $resetAt,
                            ]);
                        }
                    }

                    $resp = [
                        'status' => true,
                        'message' => 'Trial processed using Free Plan configuration',
                        'data' => [
                            'event' => $event,
                            'merchant' => $merchantId,
                            'plan' => $planKey,
                            'monthly_voice_limit' => $monthlyLimit,
                            'trial_end_date' => $endDate,
                        ]
                    ];
                } catch (\Exception $e) {
                    $this->logger->info('Trial processing error: ' . $e->getMessage());
                }
                break;

            case 'app.subscription.started':
            case 'app.subscription.renewed':
            case 'app.subscription.updated':
                try {
                    $merchantId = $params['merchant'] ?? null;
                    $subData = $params['data'] ?? [];
                    $rawPlanName = $subData['plan_name'] ?? 'Free Plan';
                    $startDate = $subData['start_date'] ?? null;
                    $endDate = $subData['end_date'] ?? null;

                    // Standardize plan slug (e.g., "Basic Plan" -> "basic")
                    $slugCandidate = Str::slug($rawPlanName);
                    $cleanSlug = strtolower(trim(str_replace(['-plan', 'plan-'], '', $slugCandidate)));

                    $planConfig = null;
                    if (class_exists(VoicePlanConfiguration::class)) {
                        $planConfig = VoicePlanConfiguration::where('is_active', true)
                            ->where(function ($q) use ($rawPlanName, $slugCandidate, $cleanSlug) {
                                $q->where('slug', $cleanSlug)
                                  ->orWhere('slug', $slugCandidate)
                                  ->orWhere('name', 'LIKE', "%{$rawPlanName}%");
                            })->first();
                    }

                    $planKey = $planConfig ? $planConfig->slug : ($cleanSlug ?: 'free');
                    $monthlyLimit = $planConfig
                        ? $planConfig->monthly_search_limit
                        : (class_exists(VoicePlanConfiguration::class) ? VoicePlanConfiguration::getLimitForSlug($planKey) : 100);

                    $resetAt = $endDate ? Carbon::parse($endDate) : Carbon::now()->addMonth();

                    if ($merchantId) {
                        $merchant = VoiceMerchant::where('merchant_identifier', (string)$merchantId)->first();
                        if (!$merchant) {
                            $merchant = VoiceMerchant::where('store_reference', (string)$merchantId)->first();
                        }

                        if ($merchant) {
                            $merchant->update([
                                'plan' => $planKey,
                                'monthly_voice_limit' => $monthlyLimit,
                                'voice_usage_count' => 0,
                                'usage_reset_at' => $resetAt,
                            ]);
                        } else {
                            $merchant = VoiceMerchant::create([
                                'merchant_identifier' => (string)$merchantId,
                                'store_reference' => (string)$merchantId,
                                'plan' => $planKey,
                                'monthly_voice_limit' => $monthlyLimit,
                                'voice_usage_count' => 0,
                                'usage_reset_at' => $resetAt,
                            ]);
                        }
                    }

                    $resp = [
                        'status' => true,
                        'message' => 'Subscription processed successfully',
                        'data' => [
                            'event' => $event,
                            'merchant' => $merchantId,
                            'plan' => $planKey,
                            'monthly_voice_limit' => $monthlyLimit,
                        ]
                    ];
                } catch (\Exception $e) {
                    $this->logger->info('Subscription processing error: ' . $e->getMessage());
                }
                break;

            case 'app.subscription.expired':
            case 'app.subscription.canceled':
            case 'app.subscription.deleted':
            case 'app.trial.expired':
            case 'app.trial.ended':
                try {
                    $merchantId = $params['merchant'] ?? null;
                    if ($merchantId) {
                        $freeLimit = class_exists(VoicePlanConfiguration::class)
                            ? VoicePlanConfiguration::getLimitForSlug('free')
                            : 100;

                        $merchant = VoiceMerchant::where('merchant_identifier', (string)$merchantId)->first();
                        if (!$merchant) {
                            $merchant = VoiceMerchant::where('store_reference', (string)$merchantId)->first();
                        }

                        if ($merchant) {
                            $merchant->update([
                                'plan' => 'free',
                                'monthly_voice_limit' => $freeLimit,
                            ]);
                        }
                    }

                    $resp = [
                        'status' => true,
                        'message' => 'Subscription/Trial cancellation processed successfully',
                        'data' => ['event' => $event]
                    ];
                } catch (\Exception $e) {
                    $this->logger->info('Subscription/Trial expiration error: ' . $e->getMessage());
                }
                break;

            case 'app.settings.updated':
                $merchant = VoiceMerchant::where('merchant_identifier', $params['merchant'] ?? null)->first();
                $data = [
                    'event' => $event,
                    'data' => $merchant
                ];
                break;
            case 'app.uninstalled':
                $resp = [
                    'status' => true,
                    'data' => ['event' => $event]
                ];
                break;
        }

        if (isset($data)) {
            return response()->json($data);
        }
        return response()->json($resp);
    }
}

