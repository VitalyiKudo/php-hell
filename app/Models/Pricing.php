<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;


class Pricing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'source_id',
        'departure',
        'arrival',
        'time_turbo',
        'price_turbo',
        'time_light',
        'price_light',
        'time_medium',
        'price_medium',
        'time_heavy',
        'price_heavy',
        'departure_geoId',
        'arrival_geoId',
    ];

    /**
     * Get the departure of the city.
     */
    public function departureCity()
    {
        return $this->belongsTo(City::class, 'departure_geoId', 'geonameid');
    }

    /**
     * Get the arrival of the city.
     */
    public function arrivalCity()
    {
        return $this->belongsTo(City::class, 'arrival_geoId', 'geonameid');
    }
}
