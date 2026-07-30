<?php

namespace Mega\SallaVoiceAI\Console\Commands;

use Illuminate\Console\Command;
use Mega\SallaVoiceAI\Models\VoiceMerchant;
use App\Models\VoiceMerchant as AppVoiceMerchant;
use Carbon\Carbon;

class ResetVoiceUsageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voice:reset-usage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset monthly voice search usage counts for merchants whose billing cycle has reset.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $merchants = VoiceMerchant::where(function ($q) use ($now) {
            $q->whereNull('usage_reset_at')
              ->orWhere('usage_reset_at', '<=', $now);
        })->get();

        $count = 0;

        foreach ($merchants as $merchant) {
            $merchant->checkAndResetMonthlyUsage();
            $count++;
        }

        $this->info("Successfully reset voice search usage for {$count} merchant(s).");

        return Command::SUCCESS;
    }
}
