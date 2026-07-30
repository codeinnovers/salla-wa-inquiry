<?php

namespace Mega\SallaVoiceAI\Models;

use Illuminate\Database\Eloquent\Model;

class VoiceLog extends Model
{
    protected $table = 'voice_logs';

    protected $fillable = [
        'store_id',
        'query',
        'ai_response',
    ];

    protected $casts = [
        'ai_response' => 'array',
    ];

    /**
     * Relationship: VoiceLog belongs to Store
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}