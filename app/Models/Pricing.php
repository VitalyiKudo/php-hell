<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'departure_city',
        'departure_city_to_airport',
        'arrival_city',
        'arrival_city_to_airport',
        'price_first',
        'price_second',
    ];

}
