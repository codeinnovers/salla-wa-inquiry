<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\VoiceMerchant;
use App\Models\VoicePlanConfiguration;
use Carbon\Carbon;

class VoiceMerchantEdit extends Component
{
    public VoiceMerchant $voiceMerchant;

    public string $plan = 'free';
    public int $monthly_voice_limit = 100;
    public int $voice_usage_count = 0;

    public function mount(VoiceMerchant $voiceMerchant)
    {
        $this->authorize('update', $voiceMerchant);

        $this->voiceMerchant = $voiceMerchant;
        $this->plan = strtolower($voiceMerchant->plan ?? 'free');
        $this->monthly_voice_limit = $voiceMerchant->getMonthlyLimit();
        $this->voice_usage_count = $voiceMerchant->voice_usage_count ?? 0;
    }

    public function updatedPlan($value)
    {
        $value = strtolower($value);
        if ($value === 'custom') {
            return;
        }
        $this->monthly_voice_limit = VoicePlanConfiguration::getLimitForSlug($value);
    }

    public function save()
    {
        $this->authorize('update', $this->voiceMerchant);

        $this->validate([
            'plan' => 'required|string|max:255',
            'monthly_voice_limit' => 'required|integer|min:0',
            'voice_usage_count' => 'required|integer|min:0',
        ]);

        $this->voiceMerchant->update([
            'plan' => strtolower($this->plan),
            'monthly_voice_limit' => $this->monthly_voice_limit,
            'voice_usage_count' => $this->voice_usage_count,
            'usage_reset_at' => $this->voiceMerchant->usage_reset_at ?? Carbon::now()->addMonth(),
        ]);

        session()->flash('message', 'Merchant subscription plan updated successfully!');

        return redirect()->route('dashboard.voice-merchants.index');
    }

    public function resetUsage()
    {
        $this->voice_usage_count = 0;
        $this->voiceMerchant->update([
            'voice_usage_count' => 0,
            'usage_reset_at' => Carbon::now()->addMonth(),
        ]);

        session()->flash('message', 'Merchant voice search usage reset to 0!');
    }

    public function render()
    {
        $availablePlans = VoicePlanConfiguration::where('is_active', true)->get();

        return view('livewire.dashboard.voice-merchants.edit', [
            'availablePlans' => $availablePlans,
        ]);
    }
}

