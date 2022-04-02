<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Operator;
use App\Models\Airport;

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
