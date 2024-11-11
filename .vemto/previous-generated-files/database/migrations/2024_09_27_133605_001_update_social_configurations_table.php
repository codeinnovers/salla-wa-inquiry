<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('social_configurations', function (Blueprint $table) {
            $table->dropColumn('merchant_identifier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('social_configurations', function (Blueprint $table) {
            $table
                ->string('merchant_identifier', 255)
                ->nullable()
                ->after('id');
        });
    }
};
