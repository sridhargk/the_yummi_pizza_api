<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'customer_id' => function () {
            return \App\Customer::all()->random();
        },
        'name' => $faker->word,
        'delivery_address' => $faker->address,
        'locality' => $faker->latitude . ", " . $faker->longitude,
        'total_quantity' => $faker->numberBetween(2, 5),
        'total_amount' => $faker->randomFloat(2, 10, 500),
        'tax' => $faker->randomFloat(2, 3, 20),
        'payable_amount' => $faker->randomFloat(2, 10, 500),
    ];
});
