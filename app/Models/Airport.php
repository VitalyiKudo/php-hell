<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'city',
        'country',
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
        return $this->belongsTo('App\Models\Country');
    }
}
