<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePlateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plate_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();
        });
        
        $this->insertDefaultData();
    }

    // TODO: deve estar aqui msmo?! Ou dentro de um Seeder?!
    public function insertDefaultData()
    {
        $categories = [
            // Bebidas
            'Café','Cerveja','Destilado','Vinho','Suco','Shake',
            // Sobremesas
            'Doce','Sorvete','Torta','Bolo',
            //Salgados
            'Hambúrguer','Lanche','Massa','Pastel','Carne',
            'Pizza','Japonesa','Mexicana','Árabe','Chinesa','Brasileira',
            'Salada','Fruto do mar','Peixe','Saudável','Salgado','Padaria',
            'Alemã','Sopa'
        ];

        foreach ($categories as $cat)
            DB::table('plate_categories')->insert([
                'name' => $cat,
                'slug' => Str::slug($cat, '-'),
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plate_categories');
    }
}
