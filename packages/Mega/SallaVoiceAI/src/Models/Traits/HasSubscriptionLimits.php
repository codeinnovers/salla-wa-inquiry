<?php

namespace Mega\SallaVoiceAI\Models\Traits;

use Carbon\Carbon;

trait HasSubscriptionLimits
{
    /**
     * Plan voice search limit mapping
     */
    public static array $planLimits = [
        'free' => 100,
        'basic' => 2000,
        'pro' => 10000,
    ];

    /**
     * Get the search limit for a specific plan.
     */
    public static function getLimitForPlan(string $plan): int
    {
        $plan = strtolower($plan);

        if (class_exists(\App\Models\VoicePlanConfiguration::class)) {
            $config = \App\Models\VoicePlanConfiguration::where('slug', $plan)->where('is_active', true)->first();
            if ($config) {
                return (int) $config->monthly_search_limit;
            }
        } elseif (class_exists(\Mega\SallaVoiceAI\Models\VoicePlanConfiguration::class)) {
            $config = \Mega\SallaVoiceAI\Models\VoicePlanConfiguration::where('slug', $plan)->where('is_active', true)->first();
            if ($config) {
                return (int) $config->monthly_search_limit;
            }
        }

        $plansConfig = config('salla-ai.plans');

        if (isset($plansConfig[$plan]['limit'])) {
            return (int) $plansConfig[$plan]['limit'];
        }

        return static::$planLimits[$plan] ?? 100;
    }

    /**
     * Get merchant's monthly voice limit.
     */
    public function getMonthlyLimit(): int
    {
        return $this->monthly_voice_limit ?? static::getLimitForPlan($this->plan ?? 'free');
    }

    /**
     * Set subscription plan for the merchant.
     */
    public function setPlan(string $planName): self
    {
        $planName = strtolower($planName);
        $limit = static::getLimitForPlan($planName);

        $this->plan = $planName;
        $this->monthly_voice_limit = $limit;

        if (!$this->usage_reset_at) {
            $this->usage_reset_at = Carbon::now()->addMonth();
        }

        $this->save();

        return $this;
    }

    /**
     * Check if the monthly cycle has expired and reset usage count if needed.
     */
    public function checkAndResetMonthlyUsage(): self
    {
        $now = Carbon::now();

        if (!$this->usage_reset_at || $now->greaterThanOrEqualTo($this->usage_reset_at)) {
            $this->voice_usage_count = 0;
            $this->usage_reset_at = $now->copy()->addMonth();
            $this->save();
        }

        return $this;
    }

    /**
     * Check if monthly voice search limit has been exceeded.
     */
    public function hasExceededMonthlyLimit(): bool
    {
        $this->checkAndResetMonthlyUsage();

        return $this->voice_usage_count >= $this->getMonthlyLimit();
    }

    /**
     * Increment merchant voice search usage count.
     */
    public function incrementVoiceUsage(int $amount = 1): self
    {
        $this->increment('voice_usage_count', $amount);
        $this->refresh();

        return $this;
    }

    /**
     * Get remaining voice searches for the current billing cycle.
     */
    public function getRemainingVoiceSearches(): int
    {
        $limit = $this->getMonthlyLimit();
        $used = $this->voice_usage_count ?? 0;

        return max(0, $limit - $used);
    }
}
