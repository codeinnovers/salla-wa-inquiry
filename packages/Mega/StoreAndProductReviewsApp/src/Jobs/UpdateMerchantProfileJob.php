<?php

namespace Mega\StoreAndProductReviewsApp\Jobs;

use App\Models\StoreProductReviewsMerchant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateMerchantProfileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(StoreProductReviewsMerchant $merchant)
    {

    }

    public function handle(): void
    {
        $merchantProfileService = app(\Mega\StoreAndProductReviewsApp\Services\Merchant\MerchantProfile::class);
        $profile = $merchantProfileService->completeMerchantProfile($this->merchant);
        \Log::channel('salla_product_review_merchant')->info('profile update else');
    }

}
