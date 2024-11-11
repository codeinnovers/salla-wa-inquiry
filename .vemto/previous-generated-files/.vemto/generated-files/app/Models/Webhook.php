<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Webhook extends Model
{
    use HasFactory;

    protected $guarded = [];

//    public function merchant()
//    {
//        return $this->belongsTo(Merchant::class);
//    }
}
