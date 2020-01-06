<?php

use App\Models\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
        'price' => $faker->randomFloat(2, 10, 100),
    ];
});
