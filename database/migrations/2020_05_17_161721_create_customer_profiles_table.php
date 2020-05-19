<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('customer_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            $table->foreign('image_id')->references('id')->on('images')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_profiles');
    }
}
