<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatesTable extends Migration
{
    public function up()
    {
        Schema::create('plates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('establishment_id');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('establishment_id')->references('id')->on('establishments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('plates');
    }
}
