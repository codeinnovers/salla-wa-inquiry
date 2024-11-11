<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\FacebookConfig;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacebookConfigFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FacebookConfig::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'merchant_identifier' => fake()->word(),
            'config_name' => fake()->word(),
            'config_value' => fake()->word(),
            'merchant_id' => \App\Models\Merchant::factory(),
        ];
    }
}
