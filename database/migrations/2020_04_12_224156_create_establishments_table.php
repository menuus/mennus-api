<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentsTable extends Migration
{
    public function up()
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('foodcourt_id');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('foodcourt_id')->references('id')->on('food_courts');
        });
    }

    public function down()
    {
        Schema::dropIfExists('establishments');
    }
}
