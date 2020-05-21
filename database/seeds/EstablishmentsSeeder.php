<?php

use App\Models\EstablishmentCategories;
use App\Models\Establishments;
use App\Models\FoodCourts;
use Illuminate\Database\Seeder;

class EstablishmentsSeeder extends Seeder
{
    public function run()
    {
        Establishments::truncate();

        $foodcourt_id = FoodCourts::where('name', 'Mercadori')->first()->id;

        factory(Establishments::class, 1)->create([
            'name' => "Picanha brava",
            'food_court_id' => $foodcourt_id,
            'establishment_category_id' => EstablishmentCategories::where('name', 'Hamburgueria')->first()->id,
            'description' => 'Hamburgueria Artesanal',
            'slug' => "picanha-brava"
        ]);
        
        factory(Establishments::class, 1)->create([
            'name' => "Pizza da Nona",
            'food_court_id' => $foodcourt_id,
            'establishment_category_id' => EstablishmentCategories::where('name', 'Pizzaria')->first()->id,
            'description' => 'A tradição da familia Valentini ao seu paladar',
            'slug' => "pizza-da-nona"
        ]);

        factory(Establishments::class, 1)->create([
            'name' => "Sushicity",
            'food_court_id' => $foodcourt_id,
            'establishment_category_id' => EstablishmentCategories::where('name', 'Japonesa')->first()->id,
            'description' => 'Culinária japonesa de qualidade',
            'slug' => "sushicity"
        ]);

        factory(Establishments::class, 1)->create([
            'name' => "Mucho nacho",
            'food_court_id' => $foodcourt_id,
            'establishment_category_id' => EstablishmentCategories::where('name', 'Mexicana')->first()->id,
            'description' => 'Comida mexicana que pra quem está com fome!!',
            'slug' => "mucho-nacho"
        ]);

        factory(Establishments::class, 1)->create([
            'name' => "Vinodega",
            'food_court_id' => $foodcourt_id,
            'establishment_category_id' => EstablishmentCategories::where('name', 'Bar')->first()->id,
            'description' => 'Os melhores vinhos da região',
            'slug' => "vinodega"
        ]);

        factory(Establishments::class, 1)->create([
            'name' => "Chopp Suey",
            'food_court_id' => $foodcourt_id,
            'establishment_category_id' => EstablishmentCategories::where('name', 'Bar')->first()->id,
            'description' => 'Chopps e cervejas',
            'slug' => "chopp-suey"
        ]);

        factory(Establishments::class, 1)->create([
            'name' => "Fitway Food",
            'food_court_id' => $foodcourt_id,
            'establishment_category_id' => EstablishmentCategories::where('name', 'Veggie')->first()->id,
            'description' => 'Light food',
            'slug' => "fitway-food"
        ]);
    }
}
