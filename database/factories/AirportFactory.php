<?php

use App\Models\Country;
use Faker\Generator as Faker;

$factory->define(App\Models\Airport::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'city' => $faker->city,
        // 'country_id' => function () {
        //     return Country::inRandomOrder()->first()->id;
        // },
        'iata' => strtoupper($faker->lexify('???')),
        'icao' => strtoupper($faker->lexify('????')),
        'latitude' => $faker->latitude(),
        'longitude' => $faker->longitude(),
        'timezone' => $faker->timezone,
        'search_id' => $faker->numerify('asearch-########'),
    ];
});
