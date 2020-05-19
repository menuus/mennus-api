<?php

use App\Models\Images;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //TODO: refatorar
        Images::truncate();
        User::truncate();

        $this->call(FoodCourtsSeeder::class);
        $this->call(EstablishmentsSeeder::class);
        $this->call(PlatesSeeder::class);
        
        $this->call(UsersSeeder::class);
        $this->call(OrdersSeeder::class);
        $this->call(ImagesSeeder::class);
    }
}
