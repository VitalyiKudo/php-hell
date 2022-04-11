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
    protected $dates = ['date_departure'];

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
     * @param $id
     *
     * @return mixed
     */
    public function getEmptyLeg($id)
    {
        return  $this->where('id', $id)->with('operatorData', 'airportDeparture', 'airportArrival')->get()->map(function ($res) {
            return [
                'id' => $res->id,
                'icaoDeparture' => $res->icao_departure,
                'airportDeparture' => $res->airportDeparture->name,
                'geoNameIdCityDeparture' => $res->airportDeparture->geoNameIdCity,
                'icaoArrival' => $res->icao_arrival,
                'airportArrival' => $res->airportArrival->name,
                'geoNameIdCityArrival' => $res->airportArrival->geoNameIdCity,
                'operatorEmail' => $res->operator,
                'operatorName' => $res->operatorData->name,
                'typePlane' => $res->type_plane,
                'price' => $res->price,
                'dateDeparture' => $res->date_departure,
                'active' => $res->active
            ];
        })->at(0);
    }

}
