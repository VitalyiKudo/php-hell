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
 * @property-read City $cities
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


    /**
     *  Sort by Country custom
     *
     * @return string
     */
    public static function sortCountry($isoCountry){
        $sortCountries = ['US' => 1,];
        $rawCountrySql = '(CASE ' . collect($sortCountries)->map(function($airport, $country) use ($isoCountry) {
                return "WHEN $isoCountry = '{$country}' THEN {$airport}"; // '`co`.`iso2`'
            })->implode(' ') . ' ELSE 9999 END) ASC';
        return $rawCountrySql;
    }

    /**
     * Sort by Area custom
     *
     * @return string
     */
    public static function sortCity($geonameid){
        $sortCities = [
            5128581 => 1, #    'New York'
            4140998 => 2, #    'Washington'
            4164223 => 3, #    'Miami'
            8062678 => 4, #    'Los Angeles'
            5391959 => 5, #    'San Francisco'
            4887442 => 6, #    'Chicago'
            5419384 => 7, #    'Denver'
            7219642 => 8, #    'Tampa'
            4167147 => 9, #    'Orlando'
            4160023 => 10, #    'Jacksonville'
            4174715 => 11, #    'Tallahassee'
            4168228 => 12, #    'Pensacola'
            4180439 => 13, #    'Atlanta'
            7228070 => 14, #    'Savannah'
            4574335 => 15, #    'Charleston'
            4575352 => 16, #    'Columbia'
            4580543 => 17, #    'Greenville'
            4460243 => 18, #    'Charlotte'
            4469146 => 19, #    'Greensboro'
            4781732 => 20, #    'Richmond'
            4776222 => 21, #    'Norfolk'
            4347800 => 22, #    'Baltimore'
            5206379 => 23, #    'Pittsburgh'
            5192726 => 24, #    'Harrisburg'
            4560349 => 25, #    'Philadelphia'
            5178127 => 26, #    'Allentown'
            4145395 => 27, #    'Wilmington'
            4500546 => 28, #    'Atlantic City'
            5101798 => 29, #    'Newark'
            5144336 => 30, #    'White Plains'
            7258233 => 31, #    'East Hampton'
            5106834 => 32, #    'Albany'
            5140405 => 33, #    'Syracuse'
            5110629 => 34, #    'Buffalo'
            4835797 => 35, #    'Hartford'
            4930956 => 36, #    'Boston'
            4937346 => 37, #    'Springfield-Chicopee'
            5224151 => 38, #    'Providence'
            5089178 => 39, #    'Manchester'
            5234372 => 40, #    'Burlington'
            4975802 => 41, #    'Portland'
            4509177 => 42, #    'Columbus'
            5150529 => 43, #    'Cleveland'
            4508722 => 44, #    'Cincinnati'
            4990729 => 45, #    'Detroit'
            4994358 => 46, #    'Grand Rapids'
            4998830 => 47, #    'Lansing'
            4259418 => 48, #    'Indianapolis'
            5263045 => 49, #    'Milwaukee'
            5254962 => 50, #    'Green Bay'
            4299276 => 51, #    'Louisville'
            4297990 => 52, #    'Lexington'
            4644585 => 53, #    'Nashville'
            4634946 => 54, #    'Knoxville'
            4641239 => 55, #    'Memphis'
            4076784 => 56, #    'Montgomery'
            4049979 => 57, #    'Birmingham'
            4431410 => 58, #    'Jackson'
            4335045 => 59, #    'New Orleans'
            4315584 => 60, #    'Baton Rouge'
            4119403 => 61, #    'Little Rock'
            7702153 => 62, #    'St Louis'
            4853828 => 63, #    'Des Moines'
            5037649 => 64, #    'Minneapolis'
            4699066 => 65, #    'Houston'
            4684888 => 66, #    'Dallas'
            4671654 => 67, #    'Austin'
            4726206 => 68, #    'San Antonio'
            4544349 => 69, #    'Oklahoma City'
            4553433 => 70, #    'Tulsa'
            4393217 => 71, #    'Kansas City'
            4281733 => 72, #    'Wichita'
            5074525 => 73, #    'Omaha'
            5231851 => 74, #    'Sioux Falls'
            5412230 => 75, #    'Aspen'
            5417598 => 76, #    'Colorado Springs'
            5442727 => 77, #    'Vail'
            5441199 => 78, #    'Telluride'
            5454711 => 79, #    'Albuquerque'
            5308684 => 80, #    'Phoenix'
            5318320 => 81, #    'Tucson'
            5780993 => 82, #    'Salt Lake City'
            5809844 => 83, #    'Seattle'
            5811696 => 84, #    'Spokane'
            5746545 => 85, #    'Portland'
            1022717 => 86, #    'Las Vegas'
            5511077 => 87, #    'Reno'
            5391811 => 88, #    'San Diego'
            5389489 => 89, #    'Sacramento'
            5392912 => 90, #    'Santa Ana'
            5392171 => 91, #    'San Jose'
            5879400 => 92, #    'Anchorage'
            5856195 => 93, #    'Honolulu'
            11888109 => 94 #    'Nassau'
        ];
        $rawCitySql = '(CASE ' . collect($sortCities)->map(function($airport, $city) use ($geonameid) {
                return "WHEN $geonameid = '{$city}' THEN {$airport}"; // '`c`.`geonameid`'
            })->implode(' ') . ' ELSE 9999 END) ASC';
        return $rawCitySql;
    }
}
