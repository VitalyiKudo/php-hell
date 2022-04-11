<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SearchResultSegment
 *
 * @property int $id
 * @property int $search_result_id
 * @property string $start_airport_id
 * @property string $start_airport_name
 * @property string $start_airport_city
 * @property string $start_airport_country_code
 * @property string $start_airport_country_name
 * @property string $start_airport_icao
 * @property string $start_airport_iata
 * @property string $end_airport_id
 * @property string $end_airport_name
 * @property string $end_airport_city
 * @property string $end_airport_country_code
 * @property string $end_airport_country_name
 * @property string $end_airport_icao
 * @property string $end_airport_iata
 * @property int $block_minutes
 * @property int $flight_minutes
 * @property int $fuel_minutes
 * @property int $distance_nm
 * @property \Illuminate\Support\Carbon|null $departure_at
 * @property \Illuminate\Support\Carbon|null $arrival_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|SearchResultSegment[] $segments
 * @property-read int|null $segments_count
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment query()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereArrivalAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereBlockMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereDepartureAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereDistanceNm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereEndAirportCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereEndAirportCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereEndAirportCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereEndAirportIata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereEndAirportIcao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereEndAirportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereEndAirportName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereFlightMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereFuelMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereSearchResultId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereStartAirportCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereStartAirportCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereStartAirportCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereStartAirportIata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereStartAirportIcao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereStartAirportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereStartAirportName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchResultSegment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
