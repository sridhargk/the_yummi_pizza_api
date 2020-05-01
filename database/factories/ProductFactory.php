<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'description' => $faker->sentence,
        'image' => $faker->imageUrl(),
        'category_id' => function () {
            return \App\ProductCategory::all()->random();
        },
    ];
});
