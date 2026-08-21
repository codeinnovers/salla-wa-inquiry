<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('voice_plan_configurations')) {
            Schema::create('voice_plan_configurations', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->integer('monthly_search_limit')->default(100);
                $table->integer('days')->default(30);
                $table->decimal('price', 10, 2)->default(0.00);
                $table->string('currency')->default('SAR');
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

            // Insert default plan configurations
            DB::table('voice_plan_configurations')->insert([
                [
                    'name' => 'Free Plan',
                    'slug' => 'free',
                    'monthly_search_limit' => 100,
                    'days' => 3,
                    'price' => 0.00,
                    'currency' => 'SAR',
                    'description' => 'Default free tier with 100 searches per 3 days.',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Basic Plan',
                    'slug' => 'basic',
                    'monthly_search_limit' => 2000,
                    'days' => 30,
                    'price' => 49.00,
                    'currency' => 'SAR',
                    'description' => 'Standard tier for growing stores with 2,000 searches per 30 days.',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Pro Plan',
                    'slug' => 'pro',
                    'monthly_search_limit' => 10000,
                    'days' => 360,
                    'price' => 149.00,
                    'currency' => 'SAR',
                    'description' => 'High volume tier for large merchants with 10,000 searches per 360 days (1 year).',
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voice_plan_configurations');
    }
};
