<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StoreProductReviewsMerchant;

class StoreProductReviewsMerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoreProductReviewsMerchant::factory()
            ->count(5)
            ->create();
    }
}
