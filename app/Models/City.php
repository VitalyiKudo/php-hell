<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Airport;
use App\Models\Region;
use App\Models\AirportArea;
use App\Models\Country;

/**
 * App\Models\City
 *
 * @property int $geonameid
 * @property string|null $name
 * @property string|null $asciiname
 * @property string|null $alternatenames
 * @property string|null $iso_region
 * @property string|null $iso_countryOld
 * @property string|null $iso_country
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $timezone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Airport[] $airport
 * @property-read int|null $airport_count
 * @property-read \Illuminate\Database\Eloquent\Collection|AirportAreas[] $airportAreas
 * @property-read int|null $airport_areas_count
 * @property-read Country|null $country
 * @property-read Region|null $region
 * @property-read Region|null $regionCountry
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereAlternatenames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereAsciiname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereGeonameid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereIsoCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereIsoCountryOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereIsoRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OperatorCity[] $operatorCities
 * @property-read int|null $operator_cities_count
 */
class City extends Model
{
    use \Awobaz\Compoships\Compoships;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cities';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'geonameid';

    /**
     * @var string[]
     */
    protected $fillable = [
        'geonameid',
        'name',
        'asciiname',
        'iso_region',
        'iso_country',
        'iso_countryOld',
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
        return $this->belongsTo(Region::class, 'iso_region', 'region_id')->where('country_id', $this->country_id);
    }

    /**
     * Get the region of the city.
     */
    public function regionCountry()
    {
        return $this->belongsTo(Region::class, ['iso_country', 'iso_region'], ['country_id', 'region_id']);
    }

    /**
     * Get the airport of the city.
     */
    public function airport()
    {
        return $this->hasMany(Airport::class, 'geoNameIdCity', 'geonameid');
    }

    /**
     * Get the airportAreas of the city.
     */
    public function airportAreas()
    {
        return $this->hasMany(AirportArea::class, 'geoNameIdCity', 'geonameid');
    }

    /**
     * Get the operators of the city.
     */
    public function operatorCities()
    {
        return $this->hasMany(OperatorCity::class, 'geoNameIdCity', 'geonameid');
    }

    /**
     * Get the departure pricing of the city.
     */
    public function pricingDepartureCity()
    {
        return $this->hasMany(Pricing::class, 'departure_geoId', 'geonameid');
    }

    /**
     * Get the departure pricing of the city.
     */
    public function pricingArrivalCity()
    {
        return $this->hasMany(Pricing::class, 'arrival_geoId', 'geonameid');
    }

}
