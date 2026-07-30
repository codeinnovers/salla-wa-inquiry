<?php

namespace Mega\SallaVoiceAI\Models;

use Illuminate\Database\Eloquent\Model;
use Mega\SallaVoiceAI\Models\Traits\HasSubscriptionLimits;

class VoiceMerchant extends Model
{
    use HasSubscriptionLimits;

    protected $table = 'voice_merchants';

    protected $guarded = [];

    protected $casts = [
        'usage_reset_at' => 'datetime',
        'monthly_voice_limit' => 'integer',
        'voice_usage_count' => 'integer',
    ];
}
