<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\StoreAndProductWebhook;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreAndProductWebhookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StoreAndProductWebhook::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event' => fake()->text(255),
            'reference_number' => fake()->text(255),
            'merchant' => fake()->text(255),
            'payload' => fake()->text(),
        ];
    }
}
