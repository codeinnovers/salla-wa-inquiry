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
        Schema::table('webhooks', function (Blueprint $table) {
            $table
                ->bigInteger('merchant_id')
                ->unsigned()
                ->after('payload');
            $table
                ->foreign('merchant_id')
                ->references('id')
                ->on('merchants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webhooks', function (Blueprint $table) {
            $table->dropColumn('merchant_id');
            $table->dropForeign('webhooks_merchant_id_foreign');
        });
    }
};
