<?php

namespace Database\Seeders;

use App\Models\FacebookConfig;
use Illuminate\Database\Seeder;

class FacebookConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FacebookConfig::factory()
            ->count(5)
            ->create();
    }
}
