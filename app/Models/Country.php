<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $country_id
 * @property string $name
 * @property string $iso2
 * @property string $iso3
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $city
 * @property-read int|null $city_count
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereIso2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereIso3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereName($value)
 * @mixin \Eloquent
 */
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
     * Get the country of the region.
     */
    public function region()
    {
        #return $this->belongsTo(Region::class, 'country_id', 'country_id');
    }
    /**
     * Get the country of the city.
     */
    public function city()
    {
        return $this->hasMany(City::class, 'country_id', 'iso_country');
    }

    /**
     * Get the country of the airport.
     */
    public function airport()
    {
        #return $this->belongsTo(Airport::class, 'country_id', 'country_id');
    }

}
