<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMenuTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->bigInteger('color')->comment('Decimal representation of RGB menu color');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
        });

        $this->insertDefaultData();
    }

    // TODO: deve estar aqui msmo?! Ou dentro de um Seeder?!
    public function insertDefaultData()
    {
        DB::table('menu_types')->insert([
            [
                'name' => 'Principal',
                'slug' => 'principal',
                'description' => 'Menu de pratos principais da casa',
                'color' => hexdec('#b71c1c'),
            ],
            [
                'name' => 'Entrada',
                'slug' => 'entrada',
                'description' => 'Menu de entradas e petiscos',
                'color' => hexdec('#f57c00'),
            ],
            [
                'name' => 'Sobremesa',
                'slug' => 'sobremesa',
                'description' => 'Menu de doces e sobremesas',
                'color' => hexdec('#ec407a'),
            ],
            [
                'name' => 'Veggie',
                'slug' => 'veggie',
                'description' => 'Menu de saladas e pratos vegetarianos',
                'color' => hexdec('#afb42b'),
            ],
            [
                'name' => 'Bebidas',
                'slug' => 'bebidas',
                'description' => 'Menu de bebidas',
                'color' => hexdec('#01579b'),
            ],
            [
                'name' => 'Vinhos',
                'slug' => 'vinhos',
                'description' => 'Menu de vinhos',
                'color' => hexdec('#311b92'),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_types');
    }
}
