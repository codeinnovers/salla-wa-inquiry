<?php

namespace Mega\SallaVoiceAI\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mega\SallaVoiceAI\Models\VoiceAiMerchant;
use Mega\SallaVoiceAI\Models\VoiceLog;
use Mega\SallaVoiceAI\Services\VoiceService;

class VoiceController
{
    public function search(Request $request)
    {
        // Validate store_reference first
        $request->validate([
            'store_id' => 'required|string',
        ]);

        // Find merchant store
        $store = VoiceAiMerchant::where('merchant_identifier', $request->store_id)->first();

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store reference not found.',
            ], 404);
        }

        // 🔒 Enforce Subscription Limits
        if ($store->hasExceededMonthlyLimit()) {
            return response()->json([
                'success' => false,
                'error_code' => 'LIMIT_EXCEEDED',
                'message' => 'Monthly voice search limit exceeded. Please upgrade your subscription plan to continue.',
                'plan' => ucfirst($store->plan ?? 'free'),
                'usage' => $store->voice_usage_count,
                'limit' => $store->getMonthlyLimit(),
            ], 403);
        }

        // Validate audio file
        $request->validate([
            'audio' => 'required|file',
        ]);

        try {
            // 🎤 Voice → Text
            $audioPath = $request->file('audio')->getRealPath();
            $text = app(VoiceService::class)->speechToText($audioPath);

            if (!$text) {
                return response()->json([
                    'success' => false,
                    'message' => 'Voice not recognized',
                ]);
            }

            // 📈 Increment Merchant Usage Count
            $store->incrementVoiceUsage();

            // 🧹 Clean text & extract keywords
            $keywords = $this->extractKeywords($text);

            // 🧾 Save Log
            // VoiceLog::create([
            //     'store_id' => $store->merchant_identifier,
            //     'query' => $text,
            //     'ai_response' => $keywords,
            // ]);

            return response()->json([
                'success' => true,
                'spoken_text' => $text,
                'keywords' => $keywords,
                'remaining_searches' => $store->getRemainingVoiceSearches(),
            ]);

        } catch (\Exception $e) {
            Log::error('Voice Search Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // 🔤 Extract keywords using multi-byte character functions
    private function extractKeywords($text)
    {
        $text = mb_strtolower($text, 'UTF-8');

        // Remove non-letter characters
        $text = preg_replace('/[^\p{L}\s]/u', '', $text);

        // Stop words (EN + AR)
        $stopWords = [
            'the', 'and', 'for', 'with', 'i', 'want', 'need',
            'ابي', 'اريد', 'ابغى', 'في', 'من', 'على'
        ];

        $words = preg_split('/\s+/u', trim($text));

        return array_values(array_filter($words, function ($word) use ($stopWords) {
            return !in_array($word, $stopWords) && mb_strlen($word, 'UTF-8') > 2;
        }));
    }

    private function detectLanguage($text)
    {
        return preg_match('/[\x{0600}-\x{06FF}]/u', $text) ? 'ar' : 'en';
    }

    /**
     * Serve custom Voice AI JavaScript snippet for Salla store fronts.
     */
    public function serveScript()
    {
        $filePath = __DIR__ . '/../../resources/js/salla-voice.js';

        if (!file_exists($filePath)) {
            $filePath = __DIR__ . '/../resources/js/salla-voice.js';
        }

        if (!file_exists($filePath)) {
            return response('console.error("Salla Voice AI: Custom JS file not found on server.");', 404, [
                'Content-Type' => 'application/javascript',
                'Access-Control-Allow-Origin' => '*',
            ]);
        }

        $jsContent = file_get_contents($filePath);

        return response($jsContent, 200, [
            'Content-Type' => 'application/javascript; charset=utf-8',
            'Access-Control-Allow-Origin' => '*',
            'Cache-Control' => 'no-cache, private',
        ]);
    }
}
