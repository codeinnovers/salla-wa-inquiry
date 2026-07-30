<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\VoiceAiConfiguration;
use Illuminate\Support\Facades\Http;

class VoiceAiConfigurationEdit extends Component
{
    public ?VoiceAiConfiguration $config = null;

    public string $elevenlabs_api_key = '';
    public string $openai_api_key = '';
    public string $default_model = 'scribe_v2';
    public bool $is_active = true;

    public ?string $testStatus = null;
    public ?string $testMessage = null;

    public function mount()
    {
        $this->authorize('viewAny', VoiceAiConfiguration::class);

        $this->config = VoiceAiConfiguration::first();
        if (!$this->config) {
            $this->config = VoiceAiConfiguration::create([
                'elevenlabs_api_key' => config('salla-ai.elevenlabs_api_key', 'sk_85e83f662c270acf31a467c2ab3eaa236f761e75ee030024'),
                'openai_api_key' => config('salla-ai.openai_key', ''),
                'default_model' => 'scribe_v2',
                'is_active' => true,
            ]);
        }

        $this->elevenlabs_api_key = $this->config->elevenlabs_api_key ?? '';
        $this->openai_api_key = $this->config->openai_api_key ?? '';
        $this->default_model = $this->config->default_model ?? 'scribe_v2';
        $this->is_active = (bool) $this->config->is_active;
    }

    public function testElevenLabsKey()
    {
        $key = trim($this->elevenlabs_api_key);
        if (empty($key)) {
            $this->testStatus = 'error';
            $this->testMessage = 'Please enter an ElevenLabs API key to test.';
            return;
        }

        try {
            $response = Http::withHeaders([
                'xi-api-key' => $key,
            ])->get('https://api.elevenlabs.io/v1/user');

            if ($response->successful()) {
                $userData = $response->json();
                $subscription = $userData['subscription'] ?? [];
                $characterCount = $subscription['character_count'] ?? 0;
                $characterLimit = $subscription['character_limit'] ?? 0;

                $this->testStatus = 'success';
                $this->testMessage = "Connected successfully! Characters used: " . number_format($characterCount) . " / " . number_format($characterLimit);
            } else {
                $this->testStatus = 'error';
                $this->testMessage = "API Key Error: " . ($response->json()['detail']['message'] ?? $response->body());
            }
        } catch (\Exception $e) {
            $this->testStatus = 'error';
            $this->testMessage = "Connection failed: " . $e->getMessage();
        }
    }

    public function save()
    {
        $this->authorize('update', $this->config);

        $this->validate([
            'elevenlabs_api_key' => 'required|string|max:255',
            'openai_api_key' => 'nullable|string|max:255',
            'default_model' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $this->config->update([
            'elevenlabs_api_key' => trim($this->elevenlabs_api_key),
            'openai_api_key' => trim($this->openai_api_key),
            'default_model' => trim($this->default_model),
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'ElevenLabs & Voice AI Configuration saved successfully!');

        return redirect()->route('dashboard.voice-ai-configuration.edit');
    }

    public function render()
    {
        return view('livewire.dashboard.voice-ai-configuration.edit');
    }
}
