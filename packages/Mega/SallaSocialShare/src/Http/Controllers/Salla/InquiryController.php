<?php
namespace Mega\SallaSocialShare\Http\Controllers\Salla;
use App\Http\Controllers\Controller;
use App\Models\Webhook;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Merchant;
use App\Models\SocialConfiguration;

class InquiryController extends Controller
{

    private \Psr\Log\LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = Log::channel('salla_social_share');
    }

    public function inquiry(Request $request)
    {
        $storeId = $request->input('store_id');
        $inquiryData = [];
        try{
            $merchant = Merchant::with('socialConfigurations')->where('merchant_identifier',$storeId)->latest()->first();
            $configurations = $merchant->socialConfigurations;
            $configValues = $this->getConfigurationValues($configurations);
            $enable = $configValues['mega-whatsapp-inuiry.enable'];
            $whatsappNumber = $configValues['mega-whatsapp-inuiry.whatsapp_number'];
            $messageTemplate = $configValues['mega-whatsapp-inuiry.message'];
            $message  =$this->getInquiryMessage($request,$messageTemplate);
            $inquiryData[] = [
                'enable' => $enable,
                'admin_whatsapp_number' => $whatsappNumber,
                'whatsapp_message' => $message
            ];
            return response()->json([
                'status' => 'success',
                'data' => $inquiryData
            ]);
        }catch (\Exception $e){
            $this->logger->info($e->getMessage());
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

    public function getInquiryMessage($request,$messageTemplate){
        $productName = $request->input('product_name');
        $productUrl = $request->input('product_url');
        $customerName = $request->input('customer_name');
        $customerEmail = $request->input('customer_email');
        $customerMobile = $request->input('customer_mobile');
        $customerQuery = $request->input('customer_query');
        $rawMessage = $messageTemplate;
        $search = ['{{customer_name}}','{{customer_email}}','{{customer_mobile}}','{{product_name}}','{{product_url}}','{{customer_query}}'];
        $replace = [$customerName,$customerEmail,$customerMobile,$productName,$productUrl,$customerQuery];
        $message  = str_replace($search,$replace,$rawMessage);
        return $message;
    }


}
