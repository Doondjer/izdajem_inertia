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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('street');
            $table->string('street_nb')->nullable();
            $table->string('city');
            $table->string('county')->nullable();
            $table->string('country')->default("Srbija");
            $table->string('district')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('type')->nullable();
            $table->string('video_url')->nullable();
            $table->float('nb_room',2,1)->nullable();
            $table->decimal('longitude',10, 7);
            $table->decimal('latitude',9, 7);
            $table->string('location_id')->nullable();
            $table->string('furnish_type')->nullable();
            $table->date('available_from')->nullable();
            $table->boolean('pets_allowed')->nullable();
            $table->integer('price')->nullable();
            $table->integer('deposit')->nullable();
            $table->string('currency',3)->default('EUR');
            $table->integer('total_floor')->nullable();
            $table->integer('nb_floor')->nullable();
            $table->integer('size')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            //$table->timestamp('published_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('status_updated_at')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listings');
    }
};
