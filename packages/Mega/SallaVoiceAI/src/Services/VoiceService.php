<?php


namespace Mega\SallaVoiceAI\Services;

use Illuminate\Support\Facades\Http;

class VoiceService
{
    public function speechToText($filePath)
    {
        $apiKey = '';
        if (class_exists(\App\Models\VoiceAiConfiguration::class)) {
            $apiKey = \App\Models\VoiceAiConfiguration::getElevenLabsApiKey();
        } elseif (class_exists(\Mega\SallaVoiceAI\Models\VoiceAiConfiguration::class)) {
            $apiKey = \Mega\SallaVoiceAI\Models\VoiceAiConfiguration::getElevenLabsApiKey();
        }

        if (empty($apiKey)) {
            $apiKey = config('salla-ai.elevenlabs_api_key') ?? env('ELEVENLABS_API_KEY');
        }

        if (!$apiKey) {
            throw new \Exception("ElevenLabs API key missing in server configuration.");
        }

       $response = Http::withHeaders([
    'xi-api-key' => $apiKey,
])->attach(
    'file',
    file_get_contents($filePath),
    'audio.webm'
)->post('https://api.elevenlabs.io/v1/speech-to-text', [
    'model_id' => 'scribe_v2' // ✅ REQUIRED
]);

        $data = $response->json();
        // print_r($data);

        // Debug if needed
        // dd($data);

        if (isset($data['text'])) {
            return $data['text'];
        }

        return '';
    }
}