<?php

namespace Mega\SallaVoiceAI\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'store_id',
        'salla_product_id',
        'name',
        'price',
        'category',
        'image',
        'product_url',
        'stock'
    ];

    protected $casts = [
        'price' => 'float',
        'stock' => 'integer'
    ];

    /**
     * Relationship: Product belongs to Store
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}