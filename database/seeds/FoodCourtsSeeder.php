<?php

use App\Models\FoodCourts;
use Illuminate\Database\Seeder;

class FoodCourtsSeeder extends Seeder
{
    public function run()
    {
        FoodCourts::truncate();

        factory(FoodCourts::class, 3)->create();
    }
}
