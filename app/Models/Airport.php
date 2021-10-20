<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\Region;

class Airport extends Model
{
    use \Awobaz\Compoships\Compoships;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'city',
        'country_id',
        'region_id',
        'continent_id',
        'iata',
        'icao',
        'latitude',
        'longitude',
        'altitude',
    ];

    /**
     * Get the country of the airport.
     */
    public function country()
    {
        return $this->hasOne(Country::class, 'country_id', 'country_id');
    }

    /**
     * Get the region of the airport.
     */
    public function region()
    {
        return $this->hasOne(Region::class, ['country_id', 'region_id'], ['country_id', 'region_id']);
    }
}
