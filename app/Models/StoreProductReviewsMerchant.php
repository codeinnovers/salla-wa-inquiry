<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreProductReviewsMerchant extends Model
{
    use HasFactory;

    protected $table = 'store_product_reviews_merchants';

    protected $guarded = [];

    public function storeProductReviewsConfigurations()
    {
        return $this->hasMany(StoreProductReviewsConfiguration::class);
    }
}
