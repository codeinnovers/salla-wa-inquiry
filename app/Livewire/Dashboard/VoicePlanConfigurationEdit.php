<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\VoicePlanConfiguration;

class VoicePlanConfigurationEdit extends Component
{
    public VoicePlanConfiguration $voicePlanConfiguration;

    public string $name = '';
    public string $slug = '';
    public int $monthly_search_limit = 1000;
    public float $price = 0.00;
    public string $currency = 'SAR';
    public string $description = '';
    public bool $is_active = true;

    public function mount(VoicePlanConfiguration $voicePlanConfiguration)
    {
        $this->authorize('update', $voicePlanConfiguration);

        $this->voicePlanConfiguration = $voicePlanConfiguration;
        $this->name = $voicePlanConfiguration->name;
        $this->slug = $voicePlanConfiguration->slug;
        $this->monthly_search_limit = $voicePlanConfiguration->monthly_search_limit;
        $this->price = (float) $voicePlanConfiguration->price;
        $this->currency = $voicePlanConfiguration->currency;
        $this->description = $voicePlanConfiguration->description ?? '';
        $this->is_active = (bool) $voicePlanConfiguration->is_active;
    }

    public function save()
    {
        $this->authorize('update', $this->voicePlanConfiguration);

        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:voice_plan_configurations,slug,' . $this->voicePlanConfiguration->id,
            'monthly_search_limit' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $this->voicePlanConfiguration->update([
            'name' => $this->name,
            'slug' => strtolower($this->slug),
            'monthly_search_limit' => $this->monthly_search_limit,
            'price' => $this->price,
            'currency' => strtoupper($this->currency),
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Plan search configuration updated successfully!');

        return redirect()->route('dashboard.voice-plan-configurations.index');
    }

    public function render()
    {
        return view('livewire.dashboard.voice-plan-configurations.edit');
    }
}
