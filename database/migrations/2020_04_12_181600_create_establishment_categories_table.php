<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishment_categories', function (Blueprint $table) {
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
            'Bar','Hamburgueria','Pizzaria','Churrascaria','Padaria','Sorveteria',
            'Japonesa','Italiana','Árabe','Mexicana','Asiática','Vegetariana',
            'Pastelaria','Lanchonete','Chopperia'
        ];

        foreach ($categories as $cat)
            DB::table('establishment_categories')->insert([
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
        Schema::dropIfExists('establishment_categories');
    }
}
