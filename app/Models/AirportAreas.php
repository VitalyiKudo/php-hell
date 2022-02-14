<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Airport;
use App\Models\City;

class AirportAreas extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'icao',
        'geoNameIdCity',
    ];

    /**
     * Get the area of the airport.
     */
    public function airport()
    {
        return $this->belongsTo(Airport::class, 'icao', 'icao');
    }

    /**
     * Get the area of the city.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'geoNameIdCity', 'geonameid');
    }
}
