<?php

use Faker\Generator as Faker;

$factory->define(App\Models\SearchResultSegment::class, function (Faker $faker) {
    return [
        'start_airport_id' => $faker->numerify('aport-####'),
        'start_airport_name' => $faker->company,
        'start_airport_city' => $faker->city,
        'start_airport_country_code' => $faker->countryCode,
        'start_airport_country_name' => $faker->country,
        'start_airport_icao' => $faker->randomElement(['ESSA', 'ESGG']),
        'start_airport_iata' => $faker->randomElement(['ARN', 'GOT']),
        'end_airport_id' => $faker->numerify('aport-####'),
        'end_airport_name' => $faker->company,
        'end_airport_city' => $faker->city,
        'end_airport_country_code' => $faker->randomElement(['ESSA', 'ESGG']),
        'end_airport_country_name' => $faker->country,
        'end_airport_icao' => $faker->randomElement(['ARN', 'GOT']),
        'end_airport_iata' => $faker->randomElement(['ARN', 'GOT']),
        'block_minutes' => $faker->numberBetween(0, 60),
        'flight_minutes' => $faker->numberBetween(20, 120),
        'fuel_minutes' => $faker->numberBetween(0, 30),
        'distance_nm' => $faker->numberBetween(100, 900),
        'departure_at' => $faker->dateTimeBetween('-3 months', '3 months'),
        'arrival_at' => function (array $segment) {
            if (! is_null($segment['departure_at'])) {
                return (clone $segment['departure_at'])->modify('+3 hours');
            }

            return null;
        },
    ];
});
