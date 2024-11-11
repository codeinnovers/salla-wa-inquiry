<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SocialConfiguration;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocialConfigurationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SocialConfiguration::class;

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
            'merchant_id' => \App\Models\Merchant::factory(),
        ];
    }
}
