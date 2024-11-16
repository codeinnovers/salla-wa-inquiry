<?php
namespace Mega\SallaSocialShare\Jobs\Merchant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Merchant;


class UpdateMerchantProfileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Merchant $merchant
    )
    {
    }

    public function handle(): void
    {
        $merchantProfileService = app(\Mega\SallaSocialShare\Services\Merchant\MerchantProfile::class);
        $profile = $merchantProfileService->completeMerchantProfile($this->merchant);
        \Log::channel('salla_social_share_merchant')->info('profile update else');
    }
}
