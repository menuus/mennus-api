<?php

use App\Models\Establishments;
use App\Models\Plates;
use Illuminate\Database\Seeder;

class PlatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plates::truncate();

        $amount = Establishments::all()->count() * 10;

        factory(Plates::class, $amount)->create();
    }
}
