<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VoiceWebhook extends Model
{
    use HasFactory;

    protected $table = 'voice_webhooks';

    protected $guarded = [];
}
