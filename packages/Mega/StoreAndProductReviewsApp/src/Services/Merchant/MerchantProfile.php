<?php

namespace Mega\StoreAndProductReviewsApp\Services\Merchant;

use App\Models\StoreProductReviewsMerchant;
use Illuminate\Support\Facades\Log;

class MerchantProfile
{
    public function completeMerchantProfile($merchant)
    {
        if(is_numeric($merchant)){
            $merchant = StoreProductReviewsMerchant::find($merchant);
        }
        $profileInfo = json_decode($this->viewProfile($merchant->access_token),true);
        Log::channel('store_product_merchant')->info('merchant profile update res '.json_encode($profileInfo));
        if (is_array($profileInfo)) {
            if($profileInfo['status'] == 200 && $profileInfo['success'] == 'true'){
                $name = $profileInfo['data']['name'];
                $email = $profileInfo['data']['email'];
                $storeLink = $profileInfo['data']['merchant']['domain'];
                $storeLogo = $profileInfo['data']['merchant']['avatar'];
                try {
                    $data['name'] = $name;
                    $data['email'] = $email;
                    $data['store_link'] = $storeLink;
                    $merchant = StoreProductReviewsMerchant::updateOrCreate(['merchant_identifier' => $merchant['merchant_identifier']],$data);
                    $merchantInfo = [
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'app_name' => "Store Product Review",
                        'teamName' => "Team Coding Home"
                    ];
                    // TODO Send Welcome Mail
                } catch (ValidatorException $e) {

                } catch(\Exception $e) {
                    Log::channel('store_product_merchant')->info('merchant profile update error '.$e->getMessage());
                }

            }
        }
        return false;
    }


    public function viewProfile($token){
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
        return  $response;
    }
}
