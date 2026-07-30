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
        if (!Schema::hasTable('voice_ai_configurations')) {
            Schema::create('voice_ai_configurations', function (Blueprint $table) {
                $table->id();
                $table->string('elevenlabs_api_key')->nullable();
                $table->string('openai_api_key')->nullable();
                $table->string('default_model')->default('scribe_v2');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

            // Insert initial default configuration if key exists in config/env
            DB::table('voice_ai_configurations')->insert([
                'elevenlabs_api_key' => config('salla-ai.elevenlabs_api_key', 'sk_85e83f662c270acf31a467c2ab3eaa236f761e75ee030024'),
                'openai_api_key' => config('salla-ai.openai_key'),
                'default_model' => 'scribe_v2',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voice_ai_configurations');
    }
};
