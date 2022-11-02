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
        Schema::create('securities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon');
            $table->timestamps();
        });

        Schema::create('listing_security', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('listing_id');
            $table->unsignedBigInteger('security_id');
            $table->timestamps();

            $table->unique(['listing_id', 'security_id']);

            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
            $table->foreign('security_id')->references('id')->on('securities')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listing_security');
        Schema::dropIfExists('securities');
    }
};
