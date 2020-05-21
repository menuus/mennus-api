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
            $table->unsignedBigInteger('food_court_id');
            $table->unsignedBigInteger('establishment_category_id');
            $table->unsignedBigInteger('logo_image_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            $table->foreign('food_court_id')->references('id')->on('food_courts');
            $table->foreign('establishment_category_id')->references('id')->on('establishment_categories');
            $table->foreign('logo_image_id')->references('id')->on('images')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('establishments');
    }
}
