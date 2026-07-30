<?php

namespace Mega\SallaVoiceAI\Services\Merchant;

use Mega\SallaVoiceAI\Models\VoiceMerchant;
use App\Models\VoiceMerchant as AppVoiceMerchant;
use Illuminate\Support\Facades\Log;

class MerchantProfile
{
    public function completeMerchantProfile($merchant)
    {
        if (is_numeric($merchant)) {
            $merchant = VoiceMerchant::find($merchant) ?? AppVoiceMerchant::find($merchant);
        }

        if (!$merchant || empty($merchant->access_token)) {
            return false;
        }

        $profileInfo = json_decode($this->viewProfile($merchant->access_token), true);
        Log::channel('salla_voice_ai_merchant')->info('merchant profile update res ' . json_encode($profileInfo));

        if (is_array($profileInfo)) {
            if (isset($profileInfo['status']) && $profileInfo['status'] == 200 && isset($profileInfo['success']) && ($profileInfo['success'] === true || $profileInfo['success'] === 'true')) {
                $name = $profileInfo['data']['name'] ?? null;
                $email = $profileInfo['data']['email'] ?? null;
                $storeLink = $profileInfo['data']['merchant']['domain'] ?? null;
                $storeLogo = $profileInfo['data']['merchant']['avatar'] ?? null;
                try {
                    $data['name'] = $name;
                    $data['email'] = $email;
                    $data['store_link'] = $storeLink;
                    $merchant = VoiceMerchant::updateOrCreate(
                        ['merchant_identifier' => $merchant['merchant_identifier']],
                        $data
                    );
                    return $merchant;
                } catch (\Exception $e) {
                    Log::channel('salla_voice_ai_merchant')->info('merchant profile update error ' . $e->getMessage());
                }
            }
        }
        return false;
    }

    public function viewProfile($token)
    {
        $url = 'https://api.salla.dev/admin/v2/oauth2/user/info';
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $token",
                "Content-Type: application/json"
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return false;
        }
        return $response;
    }
}
