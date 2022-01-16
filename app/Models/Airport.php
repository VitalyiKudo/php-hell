<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'iso_country',
        'iso_region',
        'iata',
        'icao',
        'latitude',
        'longitude',
    ];

    /**
     * Get the country of the city.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'iso_country', 'country_id');
    }

    /**
     * Get the region of the city.
     */
    public function region()
    {
        return $this->hasOneThrough(Region::class, City::class);
    }

    public function regionsHasMany()
    {
        return $this->hasManyThrough(
            Region::class,
            City::class,
            'geonameid', // city for airport
            ['country_id', 'region_id'], // region for city
            'geoNameIdCity', // Local airport for city
            ['iso_country', 'iso_region'] // Local city for region
        );
    }

    public function regionsBelongs()
    {
        return $this->belongsToMany(
            Region::class,
            City::class,
            'geonameid', // city for airport
            'iso_region', // region for city
            'geoNameIdCity', // Local airport for city
            'region_id' // Local city for region
        );
    }
    /**
     * Get the airport of the city.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'geoNameIdCity', 'geonameid');
    }

    /**
     * Get the airport of the city.
     */
    public function cityFull()
    {
        return $this->belongsTo(City::class, ['geoNameIdCity', 'iso_country', 'geoNameIdCity'], ['geonameid', 'iso_country', 'iso_region']);
    }

    /**
     * Get the region of the city.
     */
    public function regionCountry()
    {
        return $this->belongsTo(Region::class, ['iso_country', 'iso_region'], ['country_id', 'region_id']);
    }
}
