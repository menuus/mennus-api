<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Establishments;
use App\Models\MenuTypes;
use App\Models\PlateCategories;
use App\Models\Plates;
use Faker\Generator as Faker;

$factory->define(Plates::class, function (Faker $faker) {
    $faker->addProvider(new \FakerRestaurant\Provider\pt_BR\Restaurant($faker));
    //reference: https://github.com/jzonta/FakerRestaurant
    $establishmentsIds = Establishments::pluck('id')->toArray();
    $menuTypesIds = MenuTypes::pluck('id')->toArray();
    $plateCategoriesIds = PlateCategories::pluck('id')->toArray();
    return [
        'name' => $name = $faker->foodName(),
        'establishment_id' => $faker->randomElement($establishmentsIds),
        'menu_type_id' => $faker->randomElement($menuTypesIds),
        'plate_category_id' => $faker->randomElement($plateCategoriesIds),
        'description' => $faker->sentence(6),
        'slug' => Str::slug($name, '-'),
        'price' => $faker->randomFloat(2, 5, 50),
    ];
});
