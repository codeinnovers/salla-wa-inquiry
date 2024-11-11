<?php

namespace Database\Factories;

use App\Models\Merchant;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class MerchantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Merchant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'merchant_identifier' => fake()->word(),
            'name' => fake()->name(),
            'email' => fake()
                ->unique()
                ->safeEmail(),
            'store_link' => fake()->word(),
            'store_reference' => fake()->word(),
            'access_token' => fake()->word(),
            'refresh_token' => fake()->word(),
            'token_exp' => fake()->word(),
        ];
    }
}
