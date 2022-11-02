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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('thread_id')->unsigned();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->text('body');
            $table->timestamps();

            $table->foreign('thread_id')->references('id')->on('threads');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
