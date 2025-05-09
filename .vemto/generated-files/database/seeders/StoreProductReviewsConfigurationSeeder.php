<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StoreProductReviewsConfiguration;

class StoreProductReviewsConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoreProductReviewsConfiguration::factory()
            ->count(5)
            ->create();
    }
}
