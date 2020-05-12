<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('tag');
        });

        Schema::create('plates_has_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('plate_id');
            $table->unsignedBigInteger('tag_id');

            $table->primary(['plate_id', 'tag_id']);

            //TODO: testar cascade 
            $table->foreign('plate_id')->references('id')->on('plates')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('plates_has_tags');
        Schema::dropIfExists('tags');
    }
}
