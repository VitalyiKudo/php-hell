<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;

class Search extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'search_id',
        'departure_geoId',
        'arrival_geoId'
    ];

    /**
     * Get the user of the search.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the start airport of the search.
     */
    public function start_airport()
    {
        return $this->belongsTo('App\Models\Airport', 'start_airport_id');
    }

    /**
     * Get the end airport of the search.
     */
    public function end_airport()
    {
        return $this->belongsTo('App\Models\Airport', 'end_airport_id');
    }

    /**
     * Get the start city of the search.
     */
    public function departureCity()
    {
        return $this->belongsTo(City::class, 'start_airport_id');
    }

    /**
     * Get the end city of the search.
     */
    public function arrivalCity()
    {
        return $this->belongsTo(City::class, 'end_airport_id');
    }

    /**
     * Get all of the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'id', 'search_result_id');
    }

    /**
     * Get all of the results for the search.
     */
    public function results()
    {
        return $this->hasMany('App\Models\SearchResult');
    }
}
