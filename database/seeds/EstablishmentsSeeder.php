<?php

use App\Models\Establishments;
use Illuminate\Database\Seeder;

class EstablishmentsSeeder extends Seeder
{
    public function run()
    {
        Establishments::truncate();

        factory(Establishments::class, 10)->create();
    }
}
