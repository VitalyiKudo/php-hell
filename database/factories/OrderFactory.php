<?php

use App\Models\User;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Search;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        },
        'order_status_id' => function () {
            return OrderStatus::inRandomOrder()->first()->id;
        },
        'search_result_id' => function () {
            return Search::inRandomOrder()->first()->id;
        },
        'comment' => $faker->text(),
        'price' => $faker->randomFloat(2, 10, 10000),
        'billing_address' => $faker->streetAddress,
        'billing_address_secondary' => function () use ($faker) {
            if ($faker->boolean(20)) {
                return $faker->streetAddress;
            }

            return null;
        },
        'billing_country' => $faker->country,
        'billing_city' => $faker->city,
        'billing_province' => $faker->state,
        'billing_postcode' => $faker->postcode,
    ];
});
