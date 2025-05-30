<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StoreAndProductWebhook;

class StoreAndProductWebhookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoreAndProductWebhook::factory()
            ->count(5)
            ->create();
    }
}
