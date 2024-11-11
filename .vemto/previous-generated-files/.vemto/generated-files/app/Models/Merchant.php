<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function facebookConfigs()
    {
        return $this->hasMany(FacebookConfig::class);
    }

    public function socialConfigurations()
    {
        return $this->hasMany(SocialConfiguration::class);
    }
}
