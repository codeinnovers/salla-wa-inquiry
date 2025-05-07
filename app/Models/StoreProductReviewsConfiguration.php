<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreProductReviewsConfiguration extends Model
{
    use HasFactory;

    protected $table = 'store_product_reviews_configurations';

    protected $guarded = [];

    public function storeProductReviewsMerchant()
    {
        return $this->belongsTo(StoreProductReviewsMerchant::class);
    }
}
