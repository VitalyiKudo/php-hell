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
     * Get the country of the airport.
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'country_id');
    }

    /**
     * Get the country of the airport.
     */
    public function airport()
    {
        return $this->belongsTo(Airport::class, ['country_id', 'region_id'], ['country_id', 'region_id']);
    }
}

