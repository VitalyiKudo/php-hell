<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchResult extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'result_id',
        'seller_id',
        'seller_name',
        'seller_icao',
        'lift_id',
        'aircraft_category',
        'aircraft_type',
        'price',
        'currency',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
    ];

    /**
     * Get the search of the result.
     */
    public function search()
    {
        return $this->belongsTo('App\Models\Search');
    }

    /**
     * Get all of the segments for the search result.
     */
    public function segments()
    {
        return $this->hasMany('App\Models\SearchResultSegment');
    }
}
