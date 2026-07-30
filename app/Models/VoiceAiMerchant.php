<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VoiceAiMerchant extends Model
{
    use HasFactory;

    protected $table = 'voice_merchants';

    protected $guarded = [];
}
