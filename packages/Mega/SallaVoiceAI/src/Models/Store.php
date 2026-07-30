<?php
namespace Mega\SallaVoiceAI\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'salla_store_id',
        'access_token',
        'refresh_token'
    ];
}