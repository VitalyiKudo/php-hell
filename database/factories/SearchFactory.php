<?php

use App\Models\User;
use App\Models\Airport;
use Faker\Generator as Faker;

$factory->define(App\Models\Search::class, function (Faker $faker) {
    return [
        'user_id' => function () use ($faker) {
            return $faker->boolean ? User::inRandomOrder()->first()->id : null;
        },
        'result_id' => 0,
        'start_airport_name' => function () {
            return Airport::inRandomOrder()->first()->name;
        },
        'end_airport_name' => function () {
            return Airport::inRandomOrder()->first()->name;
        },
        'departure_at' => $faker->datetime(),
        'pax' => $faker->randomDigitNotNull,
    ];
});
