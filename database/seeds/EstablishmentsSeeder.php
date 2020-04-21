<?php

use App\Models\Establishments;
use App\Models\FoodCourts;
use Illuminate\Database\Seeder;

class EstablishmentsSeeder extends Seeder
{
    public function run()
    {
        Establishments::truncate();

        $amount = FoodCourts::all()->count() * 5;

        factory(Establishments::class, $amount)->create();
    }
}
