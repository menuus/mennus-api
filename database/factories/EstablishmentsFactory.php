<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Establishments;
use App\Models\FoodCourts;
use Faker\Generator as Faker;

$factory->define(Establishments::class, function (Faker $faker) {
    $foodCourtsIds = FoodCourts::pluck('id')->toArray();
    return [
        'name' => $name = $faker->company,
        'food_court_id' => $faker->randomElement($foodCourtsIds),
        'description' => $faker->sentence(6),
        'slug' => Str::slug($name, '-'),
    ];
});
