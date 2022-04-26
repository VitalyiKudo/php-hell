<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Operator;
use App\Models\Airport;

/**
 * App\Models\EmptyLeg
 *
 * @property int $id
 * @property string $icao_departure
 * @property string $icao_arrival
 * @property int $geoNameIdCity_departure
 * @property int $geoNameIdCity_arrival
 * @property string $type_plane
 * @property string $operator
 * @property string $price
 * @property \Illuminate\Support\Carbon $date_departure
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Airport $airportArrival
 * @property-read Airport $airportDeparture
 * @property-read Operator $operatorData
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg newQuery()
 * @method static \Illuminate\Database\Query\Builder|EmptyLeg onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg whereDateDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg whereGeoNameIdCityArrival($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg whereGeoNameIdCityDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg whereIcaoArrival($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg whereIcaoDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg whereOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg whereTypePlane($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmptyLeg whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EmptyLeg withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EmptyLeg withoutTrashed()
 * @mixin \Eloquent
 */
class EmptyLeg extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date_departure', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the operator.
     */
    public function operatorData()
    {
        return $this->belongsTo(Operator::class, 'operator', 'email');
    }

    /**
     * Get the airport_departure.
     */
    public function airportDeparture()
    {
        return $this->belongsTo(Airport::class, 'icao_departure', 'icao');
    }

    /**
     * Get the airport_arrival.
     */
    public function airportArrival()
    {
        return $this->belongsTo(Airport::class, 'icao_arrival', 'icao');
    }

    /**
     * Get the departure of the city.
     */
    public function departureCity()
    {
        return $this->belongsTo(City::class, 'geoNameIdCity_departure', 'geonameid');
    }

    /**
     * Get the arrival of the city.
     */
    public function arrivalCity()
    {
        return $this->belongsTo(City::class, 'geoNameIdCity_arrival', 'geonameid');
    }

    /**
     * @return EmptyLeg[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|m.\App\Models\EmptyLeg.with[]
     */
    public function getEmptyLegs()
    {
        return  $this->with('operatorData', 'airportDeparture', 'airportArrival')
            ->get()
            ->map(function ($value) {
            return collect([
                'id' => $value->id,
                'icaoDeparture' => $value->icao_departure,
                'airportDeparture' => $value->airportDeparture->name,
                'geoNameIdCityDeparture' => $value->airportDeparture->geoNameIdCity,
                'nameCityDeparture' => $value->departureCity->name,
                'icaoArrival' => $value->icao_arrival,
                'airportArrival' => $value->airportArrival->name,
                'geoNameIdCityArrival' => $value->airportArrival->geoNameIdCity,
                'nameCityArrival' => $value->arrivalCity->name,
                'operatorEmail' => $value->operator,
                'operatorName' => $value->operatorData->name,
                'typePlane' => $value->type_plane,
                'price' => $value->price,
                'dateDeparture' => $value->date_departure,
                'active' => $value->active
            ]);
        });
    }

    /**
     * @return EmptyLeg[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|m.\App\Models\EmptyLeg.with[]
     */
    public function getEmptyLegsFull()
    {
        return  $this->with('operatorData', 'airportDeparture', 'airportArrival', 'departureCity', 'arrivalCity')->get();
    }
}
