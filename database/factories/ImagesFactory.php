<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Images;
use Faker\Generator as Faker;

$factory->define(Images::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(2), 
        'description' => $faker->sentence(6),
        'path' => $faker->imageUrl(),
    ];
});
