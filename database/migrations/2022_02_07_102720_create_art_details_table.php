<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('art_details', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('size');
            $table->string('description');
            $table->string('price');
            $table->string('discount')->nullable();
            $table->string('artType');
            $table->string('image');
            $table->string('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('art_details');
    }
}
