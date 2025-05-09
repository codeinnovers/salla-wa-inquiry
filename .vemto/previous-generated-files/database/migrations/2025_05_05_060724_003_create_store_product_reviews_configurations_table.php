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
        Schema::create('StoreProductReviewsConfiguration', function (
            Blueprint $table
        ) {
            $table->id();

            $table->text('config_name')->nullable();

            $table->text('config_value')->nullable();

            $table->bigInteger('store_product_reviews_merchant_id')->unsigned();

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table
                ->foreign('store_product_reviews_merchant_id')
                ->references('id')
                ->on('StoreProductReviewsMerchant')
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
        Schema::dropIfExists('StoreProductReviewsConfiguration');
    }
};
