<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\StoreProductReviewsConfiguration;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreProductReviewsConfigurationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StoreProductReviewsConfiguration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'config_name' => fake()->text(),
            'config_value' => fake()->text(),
            'store_product_reviews_merchant_id' => \App\Models\StoreProductReviewsMerchant::factory(),
        ];
    }
}
