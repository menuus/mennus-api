<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FoodCourts;
use Faker\Generator as Faker;

$factory->define(FoodCourts::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->sentence(2),
        'description' => $faker->sentence(6),
        'slug' => Str::slug($name, '-'),
    ];
});
