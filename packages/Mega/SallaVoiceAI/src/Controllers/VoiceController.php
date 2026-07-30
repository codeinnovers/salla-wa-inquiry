<?php

namespace Mega\SallaVoiceAI\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mega\SallaVoiceAI\Models\Product;
use Mega\SallaVoiceAI\Models\Store;
use Mega\SallaVoiceAI\Models\VoiceLog;
use Mega\SallaVoiceAI\Services\VoiceService;

class VoiceController
{
    public function search(Request $request)
    {
        try {

            $request->validate([
                'audio' => 'required|file',
            ]);

            $store = Store::findOrFail(1);

            // 🎤 Voice → Text (using ElevenLabs or your STT API)
            $audioPath = $request->file('audio')->getRealPath();
            $text = app(VoiceService::class)->speechToText($audioPath);

            if (!$text) {
                return response()->json([
                    'success' => false,
                    'message' => 'Voice not recognized'
                ]);
            }

            // 🧹 Clean text (basic normalization)
            $keywords = $this->extractKeywords($text);

            // 🛍️ Search ONLY by name
            $products = Product::where('store_id', $store->id)
                ->where(function ($q) use ($keywords) {
                    foreach ($keywords as $word) {
                        $q->orWhere('name', 'LIKE', "%{$word}%");
                    }
                })
                ->limit(20)
                ->get();

            // 🧾 Log
            VoiceLog::create([
                'store_id' => $store->id,
                'query' => $text,
                'ai_response' => json_encode($keywords),
                'results_count' => $products->count(),
                'language' => $this->detectLanguage($text)
            ]);

            return response()->json([
                'success' => true,
                'spoken_text' => $text,
                'keywords' => $keywords,
                'products' => $products
            ]);

        } catch (\Exception $e) {

            Log::error('Voice Search Error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 🔤 Extract keywords only
    private function extractKeywords($text)
    {
        $text = mb_strtolower($text);

        // Remove numbers & symbols
        $text = preg_replace('/[^\p{L}\s]/u', '', $text);

        // Stop words (EN + AR)
        $stopWords = [
            'the','and','for','with','i','want','need',
            'ابي','اريد','ابغى','في','من','على'
        ];

        $words = explode(' ', trim($text));

        return array_values(array_filter($words, function ($word) use ($stopWords) {
            return !in_array($word, $stopWords) && strlen($word) > 2;
        }));
    }

    private function detectLanguage($text)
    {
        return preg_match('/[\x{0600}-\x{06FF}]/u', $text) ? 'ar' : 'en';
    }
}