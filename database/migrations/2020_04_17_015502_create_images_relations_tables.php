<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesRelationsTables extends Migration
{
    public function createRelationImageTable($tableName, $nameId) {
        Schema::create("${tableName}_has_images", function (Blueprint $table) use ($tableName, $nameId) {
            $table->unsignedBigInteger($nameId);
            $table->unsignedBigInteger('image_id');

            $table->primary([$nameId, 'image_id']);

            $table->foreign($nameId)->references('id')->on($tableName)->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
        });
    }

    public function up()
    {
        $this->createRelationImageTable('food_courts', 'food_court_id');
        $this->createRelationImageTable('establishments', 'establishment_id');
        $this->createRelationImageTable('plates', 'plate_id');
    }

    public function down()
    {
        Schema::dropIfExists('food_courts_has_images');
        Schema::dropIfExists('establishments_has_images');
        Schema::dropIfExists('plates_has_images');
    }
}
