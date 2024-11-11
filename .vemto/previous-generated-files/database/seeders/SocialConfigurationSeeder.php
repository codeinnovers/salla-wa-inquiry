<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialConfiguration;

class SocialConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialConfiguration::factory()
            ->count(5)
            ->create();
    }
}
