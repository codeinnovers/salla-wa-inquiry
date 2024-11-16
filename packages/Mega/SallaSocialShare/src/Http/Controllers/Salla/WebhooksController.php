<?php
namespace Mega\SallaSocialShare\Http\Controllers\Salla;
use App\Http\Controllers\Controller;
use App\Models\Webhook;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Merchant;
use App\Models\SocialConfiguration;

class WebhooksController extends Controller
{

    private \Psr\Log\LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = Log::channel('salla_social_share');
    }

    public function index(Request $request)
    {
        $params = $request->all();
        try{
            $this->logger->info('webhook request: '.json_encode($params));
            $webhook = Webhook::create([
                'event' => $params['event'],
                'merchant' => $params['merchant'],
                'status'  => 'success',
                'payload' => json_encode($params),
                'reference_number' => $params['data']['id'] ?? $params['data']['id'] ?? "-",
            ]);

        }catch (\Exception $e){
            $this->logger->info($e->getMessage());
        }
        $event = $params['event'];
        $resp = [];
        switch ($event) {
            case 'app.store.authorize':
                try {
                $data['merchant_identifier'] = $params['merchant'];
                $data['access_token'] = $params['data']['access_token'];
                $data['refresh_token'] = $params['data']['refresh_token'];
                $expirationDate = \Carbon\Carbon::now()->addDays(13);
                $data['token_exp'] = $expirationDate;
                $merchant = Merchant::updateOrCreate(['merchant_identifier' => $params['merchant']],$data);
                $merchantProfileService = app(\Mega\SallaSocialShare\Services\Merchant\MerchantProfile::class);
                $merchantProfileService->completeMerchantProfile($merchant);
//              $job = new \Mega\SallaStorePickup\Jobs\Merchants\UpdateMerchantProfileJob($merchant);
//                dispatch($job);
                $resp = [
                    'status' => true,
                    'data' => ['event' => 'authorized']
                ];
                }catch (\Exception $e){
                    $this->logger->info($e->getMessage());
                }
                break;
            case 'app.settings.updated':
                $merchant = Merchant::where('merchant_identifier',$params['merchant'])->first();
                $configs = [];
                foreach ($params['data']['settings'] as $configKey => $settings){
                    foreach ($settings as $setting){
                        foreach ($setting as $key => $value){
                            $configs[] = $merchant->socialConfigurations()->updateOrCreate(
                                [
                                    'config_name' => $key
                                ],[
                                    'config_value' => $value
                                ]
                            );
                        }
                    }
                }
                $data = [
                    'event' => $event,
                    'data' => $configs
                ];
                break;
            case 'app.uninstalled' :
                $job = new \Mega\SallaStorePickup\Jobs\Application\AppUninstalledJob($webhook);
                $this->dispatch($job);
                $resp = [
                    'status' => true,
                    'data' => ['event' => $event]
                ];
            break;

        }
        if(isset($data)){
            return response()->json($data);
        }
        return response()->json($resp);
    }

}
