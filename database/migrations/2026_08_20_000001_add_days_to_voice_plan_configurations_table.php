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
        if (Schema::hasTable('voice_plan_configurations')) {
            if (!Schema::hasColumn('voice_plan_configurations', 'days')) {
                Schema::table('voice_plan_configurations', function (Blueprint $table) {
                    $table->integer('days')->default(30)->after('monthly_search_limit');
                });
            }

            // Update default days for standard plans
            DB::table('voice_plan_configurations')->where('slug', 'free')->update(['days' => 3]);
            DB::table('voice_plan_configurations')->where('slug', 'basic')->update(['days' => 30]);
            DB::table('voice_plan_configurations')->where('slug', 'pro')->update(['days' => 360]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('voice_plan_configurations') && Schema::hasColumn('voice_plan_configurations', 'days')) {
            Schema::table('voice_plan_configurations', function (Blueprint $table) {
                $table->dropColumn('days');
            });
        }
    }
};
