<?php

use App\Models\FoodCourts;
use Illuminate\Database\Seeder;

class FoodCourtsSeeder extends Seeder
{
    public function run()
    {
        FoodCourts::truncate();

        factory(FoodCourts::class, 1)->create([
            'name' => 'Mercadori',
            'description' => "A praça de alimentação tecnológica",
            'slug' => 'mercadori',
        ]);
    }
}
