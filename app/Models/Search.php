<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Search
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $result_id
 * @property string|null $start_airport_name
 * @property int $departure_geoId
 * @property string|null $end_airport_name
 * @property int $arrival_geoId
 * @property string|null $departure_at
 * @property int $pax
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $session_id
 * @property-read City $arrivalCity
 * @property-read City $departureCity
 * @property-read \App\Models\Airport $end_airport
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SearchResult[] $results
 * @property-read int|null $results_count
 * @property-read \App\Models\Airport $start_airport
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Search newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Search newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Search query()
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereArrivalGeoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereDepartureAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereDepartureGeoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereEndAirportName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search wherePax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereResultId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereStartAirportName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Search whereUserId($value)
 * @mixin \Eloquent
 */
class Search extends Model
{
    use \Awobaz\Compoships\Compoships;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'result_id',
        'session_id',
        'user_id',
        'start_airport_name',
        'end_airport_name',
        'departure_geoId',
        'arrival_geoId',
        'departure_at',
        'comment',
        'pax'
    ];

    /**
     * Get the user of the search.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
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
        return $this->belongsTo(City::class, 'departure_geoId', 'geonameid');
    }

    /**
     * Get the end city of the search.
     */
    public function arrivalCity()
    {
        return $this->belongsTo(City::class, 'arrival_geoId', 'geonameid');
    }

    /**
     * Get the start airport of the search.
     */
    public function airportDeparture()
    {
        return $this->belongsTo(Airport::class, 'start_airport_name', 'icao');
    }

    /**
     * Get the end airport of the search.
     */
    public function airportArrival()
    {
        return $this->belongsTo(Airport::class, 'end_airport_name', 'icao');
    }

    /**
     * Get all of the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'search_result_id', 'id');
    }

    /**
     * Get all of the results for the search.
     */
    public function results()
    {
        return $this->hasMany('App\Models\SearchResult');
    }

    /**
     * Get the price of the result.
     */
    public function price()
    {
        return $this->belongsTo(Pricing::class, ['departure_geoId', 'arrival_geoId'], ['departure_geoId', 'arrival_geoId']);
    }

    /**
     * Get the searches
     *
     * @return Search[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|m.\App\Models\Search.with[]
     */
    public function getSearches()
    {
        return $this->with('user')
            ->withCount('results')
            ->orderBy('id', 'desc')
            ->get()
            ->map(fn($value, $key) => [
                'key' => ++$key,
                'id' => $value->id,
                'user' => is_null($value->user) ? null : $value->user->full_name,
                'userId' => is_null($value->user) ? null : $value->user->id,
                'createdAt' => $value->created_at->format('m-d-Y H:i'),
            ]);
    }
}
