<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'country_id',
        'iso2',
        'iso3',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the country of the airport.
     */
    public function region()
    {
        return $this->hasMany('App\Models\Region', 'country_id', 'country_id');
    }

    /**
     * Get the country of the airport.
     */
    public function airport()
    {
        return $this->hasMany('App\Models\Airport', 'country_id', 'country_id');
    }

}
