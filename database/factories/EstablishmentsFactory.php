<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Establishments;
use Faker\Generator as Faker;

$factory->define(Establishments::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->company,
        'description' => $faker->sentence(6),
        'slug' => Str::slug($name, '-'),
    ];
});
