<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('establishment_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('establishment_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('establishment_profiles');
    }
}
