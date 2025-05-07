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
        Schema::dropIfExists('magic_logins');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('magic_logins', function (Blueprint $table) {
            $table->uuid('uuid');

            $table->string('authenticatable_type', 255)->index();

            $table
                ->bigInteger('authenticatable_id')
                ->unsigned()
                ->index();

            $table->integer('logins');

            $table->integer('logins_limit');

            $table->string('guard', 255);

            $table->string('redirect_url', 255);

            $table->dateTime('expires_at');

            $table->json('metadata');

            $table->timestamp('created_at')->nullable();

            $table->timestamp('updated_at')->nullable();

            $table->index(['authenticatable_type', 'authenticatable_id']);
        });
    }
};
