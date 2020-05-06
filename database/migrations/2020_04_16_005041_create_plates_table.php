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
            $table->unsignedBigInteger('menu_type_id');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->foreign('menu_type_id')->references('id')->on('menu_types');
        });
    }

    public function down()
    {
        Schema::dropIfExists('plates');
    }
}
