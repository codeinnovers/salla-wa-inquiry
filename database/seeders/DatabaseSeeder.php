<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::where('email', 'admin@admin.com')->doesntExist()) {
            User::factory()
                ->count(1)
                ->create([
                    'email' => 'admin@admin.com',
                    'password' => \Hash::make('admin'),
                ]);
        }

        $this->call([
            WebhookSeeder::class,
            MerchantSeeder::class,
            ProductSeeder::class,
            SocialConfigurationSeeder::class,
            StoreAndProductWebhookSeeder::class,
            StoreProductReviewsMerchantSeeder::class,
            StoreProductReviewsConfigurationSeeder::class,
        ]);
    }
}
