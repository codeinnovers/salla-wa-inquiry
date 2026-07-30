<?php

namespace Mega\SallaVoiceAI\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VoiceAiConfiguration extends Model
{
    use HasFactory;

    protected $table = 'voice_ai_configurations';

    protected $fillable = [
        'elevenlabs_api_key',
        'openai_api_key',
        'default_model',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getElevenLabsApiKey(): string
    {
        $config = static::where('is_active', true)->whereNotNull('elevenlabs_api_key')->latest()->first();
        if ($config && !empty($config->elevenlabs_api_key)) {
            return $config->elevenlabs_api_key;
        }

        return config('salla-ai.elevenlabs_api_key') ?? env('ELEVENLABS_API_KEY', '');
    }
}
