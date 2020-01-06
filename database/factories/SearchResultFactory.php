<?php

use Faker\Generator as Faker;

$factory->define(App\Models\SearchResult::class, function (Faker $faker) {
    return [
        'result_id' => $faker->numerify('asearchhit-#########'),
        'seller_id' => $faker->uuid,
        'seller_name' => $faker->company,
        'seller_icao' => 'ACA',
        'lift_id' => $faker->uuid,
        'aircraft_category' => 'Light jet',
        'aircraft_type' => 'Citation CJ2',
        'price' => $faker->randomFloat(2, 5000, 20000),
        'currency' => $faker->currencyCode,
    ];
});
