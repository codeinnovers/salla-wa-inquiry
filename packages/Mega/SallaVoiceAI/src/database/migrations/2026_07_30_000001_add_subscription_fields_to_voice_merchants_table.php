<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('voice_merchants')) {
            Schema::table('voice_merchants', function (Blueprint $table) {
                if (!Schema::hasColumn('voice_merchants', 'plan')) {
                    $table->string('plan')->default('free')->after('store_reference');
                }
                if (!Schema::hasColumn('voice_merchants', 'monthly_voice_limit')) {
                    $table->integer('monthly_voice_limit')->default(100)->after('plan');
                }
                if (!Schema::hasColumn('voice_merchants', 'voice_usage_count')) {
                    $table->integer('voice_usage_count')->default(0)->after('monthly_voice_limit');
                }
                if (!Schema::hasColumn('voice_merchants', 'usage_reset_at')) {
                    $table->timestamp('usage_reset_at')->nullable()->after('voice_usage_count');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('voice_merchants')) {
            Schema::table('voice_merchants', function (Blueprint $table) {
                $columns = [];
                if (Schema::hasColumn('voice_merchants', 'plan')) {
                    $columns[] = 'plan';
                }
                if (Schema::hasColumn('voice_merchants', 'monthly_voice_limit')) {
                    $columns[] = 'monthly_voice_limit';
                }
                if (Schema::hasColumn('voice_merchants', 'voice_usage_count')) {
                    $columns[] = 'voice_usage_count';
                }
                if (Schema::hasColumn('voice_merchants', 'usage_reset_at')) {
                    $columns[] = 'usage_reset_at';
                }
                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
