<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('establishment_id');
            $table->string('obs')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('establishment_id')->references('id')->on('establishments');
        });

        Schema::create("orders_has_plates", function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('plate_id');
            $table->integer('plates_amount');
            $table->double('price');

            $table->primary(['order_id', 'plate_id']);

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('plate_id')->references('id')->on('plates')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders_has_plates');
        Schema::dropIfExists('orders');
    }
}
