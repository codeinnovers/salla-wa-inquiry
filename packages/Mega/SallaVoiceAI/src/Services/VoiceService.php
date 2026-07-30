<?php


namespace Mega\SallaVoiceAI\Services;

use Illuminate\Support\Facades\Http;

class VoiceService
{
    public function speechToText($filePath)
    {
        $apiKey = 'sk_85e83f662c270acf31a467c2ab3eaa236f761e75ee030024';

        if (!$apiKey) {
            throw new \Exception("ElevenLabs API key missing");
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