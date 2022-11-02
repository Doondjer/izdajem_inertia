<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('provider', 30);
            $table->string('provider_user_id', 100);
            $table->string('avatar')->nullable();
            $table->string('access_token');
            $table->string('refresh_token')->nullable();
            $table->unsignedInteger('expires_in')->nullable();
            $table->timestamps();

            $table->unique([
                'provider',
                'provider_user_id'
            ]);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_accounts');
    }
};
