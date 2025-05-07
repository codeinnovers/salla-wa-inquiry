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
        Schema::create('store_and_product_webhooks', function (Blueprint $table) {
            $table->id();

            $table->string('event')->nullable();

            $table->string('reference_number')->nullable();

            $table->string('merchant');

            $table->longText('payload');

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('StoreAndProductWebhook');
    }
};
