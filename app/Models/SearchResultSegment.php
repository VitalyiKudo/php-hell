<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchResultSegment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_airport_id',
        'start_airport_name',
        'start_airport_city',
        'start_airport_country_code',
        'start_airport_country_name',
        'start_airport_icao',
        'start_airport_iata',
        'end_airport_id',
        'end_airport_name',
        'end_airport_city',
        'end_airport_country_code',
        'end_airport_country_name',
        'end_airport_icao',
        'end_airport_iata',
        'block_minutes',
        'flight_minutes',
        'fuel_minutes',
        'distance_nm',
        'departure_at',
        'arrival_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'departure_at',
        'arrival_at',
    ];

    /**
     * Get all of the segments for the search result.
     */
    public function segments()
    {
        return $this->hasMany('App\Models\SearchResultSegment');
    }
}
