<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\StoreProductReviewsMerchant;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreProductReviewsMerchantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StoreProductReviewsMerchant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'merchant_identifier' => fake()->text(255),
            'name' => fake()->name(),
            'email' => fake()
                ->unique()
                ->safeEmail(),
            'store_link' => fake()->text(255),
            'store_reference' => fake()->text(255),
            'access_token' => fake()->text(),
            'refresh_token' => fake()->text(),
            'token_exp' => fake()->date(),
        ];
    }
}
