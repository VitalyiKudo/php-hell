<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use \Awobaz\Compoships\Compoships;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'region_id',
        'country_id',
        'code',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the region of the country.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }

    /**
     * Get the region of the airport.
     */
    public function airport()
    {
#        return $this->hasMany(Airport::class, ['country_id', 'region_id'], ['iso_country', 'iso_region']);
    }

    /**
     * Get the region of the city.
     */
    public function city()
    {
        return $this->hasMany(City::class, ['country_id', 'region_id'], ['iso_country', 'iso_region']);
    }
}
