<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Region
 *
 * @property int $id
 * @property string $region_id
 * @property string $country_id
 * @property string|null $name
 * @property string $code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $city
 * @property-read int|null $city_count
 * @property-read \App\Models\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereRegionId($value)
 * @mixin \Eloquent
 */
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

