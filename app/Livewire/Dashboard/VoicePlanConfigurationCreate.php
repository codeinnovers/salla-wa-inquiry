<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\VoicePlanConfiguration;
use Illuminate\Support\Str;

class VoicePlanConfigurationCreate extends Component
{
    public string $name = '';
    public string $slug = '';
    public int $monthly_search_limit = 1000;
    public int $days = 30;
    public float $price = 0.00;
    public string $currency = 'SAR';
    public string $description = '';
    public bool $is_active = true;

    public function mount()
    {
        $this->authorize('create', VoicePlanConfiguration::class);
    }

    public function updatedName($value)
    {
        if (empty($this->slug)) {
            $this->slug = Str::slug($value);
            $this->applyDefaultDaysForSlug($this->slug);
        }
    }

    public function updatedSlug($value)
    {
        $this->applyDefaultDaysForSlug($value);
    }

    protected function applyDefaultDaysForSlug(string $slug)
    {
        $clean = strtolower(trim($slug));
        if ($clean === 'free') {
            $this->days = 3;
        } elseif ($clean === 'basic') {
            $this->days = 30;
        } elseif ($clean === 'pro') {
            $this->days = 360;
        }
    }

    public function save()
    {
        $this->authorize('create', VoicePlanConfiguration::class);

        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:voice_plan_configurations,slug',
            'monthly_search_limit' => 'required|integer|min:0',
            'days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        VoicePlanConfiguration::create([
            'name' => $this->name,
            'slug' => strtolower($this->slug),
            'monthly_search_limit' => $this->monthly_search_limit,
            'days' => $this->days,
            'price' => $this->price,
            'currency' => strtoupper($this->currency),
            'description' => $this->description,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Plan search configuration created successfully!');

        return redirect()->route('dashboard.voice-plan-configurations.index');
    }

    public function render()
    {
        return view('livewire.dashboard.voice-plan-configurations.create');
    }
}
