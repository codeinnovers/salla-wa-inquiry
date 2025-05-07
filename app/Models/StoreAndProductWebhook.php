<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreAndProductWebhook extends Model
{
    use HasFactory;

    protected $table = 'store_and_product_webhooks';

    protected $guarded = [];
}
