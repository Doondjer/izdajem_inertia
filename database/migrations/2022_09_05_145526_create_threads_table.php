<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('listing_id')->nullable();
            $table->enum('type',['public', 'private'])->default('private');
      //      $table->unsignedBigInteger('appointment_id')->nullable()->unique()->default(NULL);
            $table->string('subject');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('listing_id')
                ->references('id')
                ->on('listings')
                ->onDelete('cascade');

        /*    $table->foreign('appointment_id')
                ->references('id')
                ->on('appointments')
                ->onDelete('cascade');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
}
