<?php

use App\Models\CustomerProfiles;
use App\Models\EstablishmentProfiles;
use App\Models\Establishments;
use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        factory(User::class, 10)->create()->each(function($user) {
            CustomerProfiles::create()->user()->save($user);
        });

        Establishments::all()->each(function ($establishment) {
            $user = factory(User::class, 1)->create([
                'name' => $establishment->name,
                'email' => "$establishment->slug@email.com",
            ])->first();

            EstablishmentProfiles::create([
                'establishment_id' => $establishment->id
            ])->user()->save($user);
        });

        factory(User::class, 1)->create()->each(function ($user) {
            $profile = CustomerProfiles::create();
            $profile->user()->save($user);
        });
    }
}
