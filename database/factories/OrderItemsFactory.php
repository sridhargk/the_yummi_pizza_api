<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OrderItems;
use Faker\Generator as Faker;

$factory->define(OrderItems::class, function (Faker $faker) {
    return [
        'order_id' => function () {
            return \App\Order::all()->random();
        },
        'name' => $faker->word,
        'description' => $faker->sentence,
        'product_id' => function () {
            return \App\Product::all()->random();
        },
        'price' => $faker->numberBetween(5, 50),
        'quantity' => $faker->numberBetween(1, 10),
        'total' => $faker->randomFloat(2, 5, 500),
    ];
});
