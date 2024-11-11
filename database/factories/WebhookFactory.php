<?php

namespace Database\Factories;

use App\Models\Webhook;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebhookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Webhook::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event' => fake()->word(),
            'reference_number' => fake()->word(),
            'status' => fake()->word(),
            'merchant' => fake()->text(255),
            'payload' => fake()->text(),
        ];
    }
}
