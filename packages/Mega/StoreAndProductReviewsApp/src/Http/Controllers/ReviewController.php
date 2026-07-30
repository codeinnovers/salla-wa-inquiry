<?php
namespace Mega\StoreAndProductReviewsApp\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Webhook;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\StoreProductReviewsMerchant;
use App\Models\StoreProductReviewsConfiguration;

class ReviewController extends Controller
{

    private \Psr\Log\LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = Log::channel('salla_social_share');
    }

   
    public function getConfigValue(Request $request){
        $storeId = $request->query('store_id');
        
        $configData = [];
        try{
             $merchant = StoreProductReviewsMerchant::with('storeProductReviewsConfigurations')->where('merchant_identifier',$storeId)->latest()->first();
             $configurations = $merchant->storeProductReviewsConfigurations;
             $configValues = $this->getConfigurationValues($configurations);
             $enable = $configValues['enable_reviews_app'];
             $buttonTitle = $configValues['reviews-button_title'];
             $popupHeaderTitle = $configValues['reviews_popup_header_title'];
             $reviewPerPage = $configValues['reviews_per_page'];
             $showReviewsOnly = $configValues['show_reviews_only'];
             $enableToastNotification = $configValues['enable_toast_notification'];
             $showTopReviewsToasts = $configValues['show_top_reviews_toasts'];
             $hideDefaultReviewsProductPage = $configValues['hide_default_reviews_from_product_page'];
             
             $configData[] = [
                'enable_reviews_app' => $enable,
                'reviews_button_title' => $buttonTitle,
                'reviews_popup_header_title' => $popupHeaderTitle,
                'reviews_per_page' => $reviewPerPage,
                'show_reviews_only' => $showReviewsOnly,
                'enable_toast_notification' => $enableToastNotification,
                'show_top_reviews_toasts' => $showTopReviewsToasts,
                'hide_default_reviews_from_product_page' => $hideDefaultReviewsProductPage,
                
            ];
            return response()->json([
                'status' => 'success',
                'data' => $configData
            ]);
            
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Store not found',
            ], 404);
        }
        
    }
    
  
    public function getConfigurationValues($configurations) {
        $configValues = [];
        foreach ($configurations as $config) {
            // Use config_name as the key and config_value as the value
            $configValues[$config['config_name']] = $config['config_value'];
        }

        return $configValues;
    }

  

}
