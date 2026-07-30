<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\VoiceMerchant;
use App\Models\VoicePlanConfiguration;
use Carbon\Carbon;

class VoiceMerchantCreate extends Component
{
    public string $merchant_identifier = '';
    public string $name = '';
    public string $email = '';
    public string $store_reference = '';
    public string $store_link = '';
    public string $plan = 'free';
    public int $monthly_voice_limit = 100;

    public function mount()
    {
        $this->authorize('create', VoiceMerchant::class);
        $this->monthly_voice_limit = VoicePlanConfiguration::getLimitForSlug($this->plan);
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
        $this->authorize('create', VoiceMerchant::class);

        $this->validate([
            'merchant_identifier' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'store_reference' => 'required|string|max:255|unique:voice_merchants,store_reference',
            'store_link' => 'nullable|string|max:255',
            'plan' => 'required|string|max:255',
            'monthly_voice_limit' => 'required|integer|min:0',
        ]);

        $voiceMerchant = VoiceMerchant::create([
            'merchant_identifier' => $this->merchant_identifier ?: null,
            'name' => $this->name ?: null,
            'email' => $this->email ?: null,
            'store_reference' => $this->store_reference,
            'store_link' => $this->store_link ?: null,
            'plan' => strtolower($this->plan),
            'monthly_voice_limit' => $this->monthly_voice_limit,
            'voice_usage_count' => 0,
            'usage_reset_at' => Carbon::now()->addMonth(),
        ]);

        session()->flash('message', 'Voice Merchant created and plan assigned successfully!');

        return redirect()->route('dashboard.voice-merchants.index');
    }

    public function render()
    {
        $availablePlans = VoicePlanConfiguration::where('is_active', true)->get();

        return view('livewire.dashboard.voice-merchants.create', [
            'availablePlans' => $availablePlans,
        ]);
    }
}

