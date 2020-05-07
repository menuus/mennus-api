<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\EstablishmentCategories;
use App\Models\Establishments;
use App\Models\FoodCourts;
use Faker\Generator as Faker;

$factory->define(Establishments::class, function (Faker $faker) {
    $foodCourtsIds = FoodCourts::pluck('id')->toArray();
    $establishmentCategoriesIds = EstablishmentCategories::pluck('id')->toArray();
    return [
        'name' => $name = $faker->company,
        'food_court_id' => $faker->randomElement($foodCourtsIds),
        'establishment_category_id' => $faker->randomElement($establishmentCategoriesIds),
        'description' => $faker->sentence(6),
        'slug' => Str::slug($name, '-'),
    ];
});
