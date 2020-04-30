<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductPrice;
use Faker\Generator as Faker;

$factory->define(ProductPrice::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            return \App\Product::all()->random();
        },
        'size' => $faker->word,
        'description' => $faker->sentence,
        'price' => $faker->numberBetween(5, 50),
    ];
});
