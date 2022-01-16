<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Airport;
use App\Models\Region;
use App\Models\Country;

class City extends Model
{
    use \Awobaz\Compoships\Compoships;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cities';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected$primaryKey = 'geonameid';

    protected $fillable = [
        'geonameid',
        'name',
        'asciiname',
        'iso_region',
        'iso_country',
        'iso_countryOld',
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
        return $this->hasMany(Region::class, 'iso_region', 'region_id')->where('country_id', $this->country_id);
    }

    /**
     * Get the region of the city.
     */
    public function regionCountry()
    {
        return $this->hasMany(Region::class, ['iso_country', 'iso_region'], ['country_id', 'region_id']);
    }

    /**
     * Get the region of the city.
     */
    public function airport()
    {
        return $this->hasMany(Airport::class, 'geoNameIdCity', 'geonameid');
        #return $this->hasMany('App\Post');
    }

    public function region13()
    {
        return $this->hasOneThrough(
            Region::class,
            City::class,
            'country_id', // city for airport
            'region_id', // region for city
            'iso_country', // Local airport for city
            'iso_region' // Local city for region
        );
    }
}
