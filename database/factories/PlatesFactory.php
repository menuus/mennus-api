<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Establishments;
use App\Models\Plates;
use Faker\Generator as Faker;

$factory->define(Plates::class, function (Faker $faker) {
    $faker->addProvider(new \FakerRestaurant\Provider\pt_BR\Restaurant($faker));
    //reference: https://github.com/jzonta/FakerRestaurant
    $establishmentsIds = Establishments::pluck('id')->toArray();
    return [
        'name' => $name = $faker->foodName(),
        'establishment_id' => $faker->randomElement($establishmentsIds),
        'description' => $faker->sentence(6),
        'slug' => Str::slug($name, '-'),
    ];
});
