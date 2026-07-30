<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mega\SallaVoiceAI\Models\Traits\HasSubscriptionLimits;

class VoiceMerchant extends Model
{
    use HasFactory, HasSubscriptionLimits;

    protected $table = 'voice_merchants';

    protected $guarded = [];

    protected $casts = [
        'usage_reset_at' => 'datetime',
        'monthly_voice_limit' => 'integer',
        'voice_usage_count' => 'integer',
    ];
}
