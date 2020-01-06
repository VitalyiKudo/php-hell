<?php

use App\User;
use App\Models\Airport;
use Faker\Generator as Faker;

$factory->define(App\Models\Search::class, function (Faker $faker) {
    return [
        'user_id' => function () use ($faker) {
            return $faker->boolean ? User::inRandomOrder()->first()->id : null;
        },
        'result_id' => $faker->numerify('asearch-########'),
        'start_airport_id' => function () {
            return Airport::inRandomOrder()->first()->id;
        },
        'end_airport_id' => function () {
            return Airport::inRandomOrder()->first()->id;
        },
        'departure_at' => $faker->datetime(),
        'pax' => $faker->randomDigitNotNull,
    ];
});
