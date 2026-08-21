<?php
namespace Mega\SallaVoiceAI\Services;

use Illuminate\Support\Facades\Http;

class AIService
{
    public function parse($text)
    {
        $res = Http::withToken(config('salla-ai.openai_key', env('OPENAI_API_KEY')))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role'=>'system','content'=>'Extract keywords and price'],
                    ['role'=>'user','content'=>$text]
                ]
            ]);
        dd($res->json());

        return json_decode($res['choices'][0]['message']['content'], true);
    }
}
