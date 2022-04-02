<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\City;

/**
 * App\Models\Airport
 *
 * @property int $id
 * @property string $name
 * @property string|null $type
 * @property \App\Models\City $city
 * @property int $geoNameIdCity
 * @property string $iso_country
 * @property string $iso_region
 * @property string|null $iata
 * @property int $geonameid
 * @property string $icao
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $timezone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AirportAreas[] $airportAreas
 * @property-read int|null $airport_areas_count
 * @property-read \App\Models\City $cityFull
 * @property-read \App\Models\Country $country
 * @property-read \App\Models\Region|null $region
 * @property-read \App\Models\Region $regionCountry
 * @method static \Illuminate\Database\Eloquent\Builder|Airport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Airport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Airport query()
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereGeoNameIdCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereGeonameid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereIata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereIcao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereIsoCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereIsoRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Airport extends Model
{
    use \Awobaz\Compoships\Compoships;
    #use SoftDeletes;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'city',
        'geoNameIdCity',
        'iso_country',
        'iso_region',
        'iata',
        'icao',
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
        #return $this->hasOneThrough(Region::class, City::class);
    }

    /**
     * Get the airport of the city.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'geoNameIdCity', 'geonameid');
    }

    /**
     * Get the airport of the city.
     */
    public function cities()
    {
        return $this->belongsTo(City::class, ['geoNameIdCity'], ['geonameid']);
    }

    /**
     * Get the region of the city.
     */
    public function regionCountry()
    {
        return $this->belongsTo(Region::class, ['iso_country', 'iso_region'], ['country_id', 'region_id']);
    }

    /**
     * Get the airportAreas of the airport.
     */
    public function airportAreas()
    {
        return $this->hasMany(AirportArea::class, 'icao', 'icao');
    }
}
