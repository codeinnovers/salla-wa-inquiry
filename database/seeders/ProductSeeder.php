<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Mega\SallaVoiceAI\Models\Store;
use Mega\SallaVoiceAI\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $store = Store::firstOrCreate(['id' => 1], [
            'salla_store_id' => '1',
            'store_name' => 'Demo Store',
            'access_token' => 'demo_token',
        ]);
        $storeId = $store->id;

        $products = [
            [
                'store_id' => $storeId,
                'salla_product_id' => 'P1',
                'name' => 'Black Shoes',
                'price' => 150,
                'category' => 'Shoes',
                'image' => '',
                'product_url' => '/product/black-shoes',
                'stock' => 10
            ],
            [
                'store_id' => $storeId,
                'salla_product_id' => 'P2',
                'name' => 'White Sneakers',
                'price' => 200,
                'category' => 'Shoes',
                'image' => '',
                'product_url' => '/product/white-sneakers',
                'stock' => 15
            ],
            [
                'store_id' => $storeId,
                'salla_product_id' => 'P3',
                'name' => 'Red Handbag',
                'price' => 80,
                'category' => 'Bags',
                'image' => '',
                'product_url' => '/product/red-handbag',
                'stock' => 5
            ],
            [
                'store_id' => $storeId,
                'salla_product_id' => 'P4',
                'name' => 'Blue T-Shirt',
                'price' => 60,
                'category' => 'Clothing',
                'image' => '',
                'product_url' => '/product/blue-tshirt',
                'stock' => 20
            ],
            [
                'store_id' => $storeId,
                'salla_product_id' => 'P5',
                'name' => 'Running Shoes Nike',
                'price' => 300,
                'category' => 'Shoes',
                'image' => '',
                'product_url' => '/product/nike-running',
                'stock' => 8
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}