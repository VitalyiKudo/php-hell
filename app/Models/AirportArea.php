<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Airport;
use App\Models\City;

/**
 * App\Models\AirportAreas
 *
 * @property int $id
 * @property string $icao
 * @property int $geoNameIdCity
 * @property int $sortBy
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Airport $airport
 * @property-read City $city
 * @method static \Illuminate\Database\Eloquent\Builder|AirportAreas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AirportAreas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AirportAreas query()
 * @method static \Illuminate\Database\Eloquent\Builder|AirportAreas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirportAreas whereGeoNameIdCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirportAreas whereIcao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirportAreas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirportAreas whereSortBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AirportAreas whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $airport_count
 * @property-read \Illuminate\Database\Eloquent\Collection|AirportArea[] $areaAirport
 * @property-read int|null $area_airport_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Airport[] $cityAirport
 * @property-read int|null $city_airport_count
 */
class AirportArea extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'icao',
        'geoNameIdCity',
    ];

    /**
     * Get the area of the airport.
     */
    public function airport()
    {
        return $this->hasMany(Airport::class, 'icao', 'icao');
    }

    /**
     * @return mixed
     */
    public function cityAirport()
    {
        return $this->hasMany(Airport::class, 'geoNameIdCity', 'geoNameIdCity');
    }

    /**
     * @return mixed
     */
    public function areaAirport()
    {
        return $this->hasMany(AirportArea::class, 'geoNameIdCity', 'geoNameIdCity');
    }

    /**
     * Get the area of the city.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'geoNameIdCity', 'geonameid');
    }

    /**
     * Get the areas
     *
     * @return AirportArea[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|m.\App\Models\AirportArea.with[]
     */
    public function getAirportAreas()
    {
        return  $this->with('city', 'city.regionCountry', 'city.country', 'cityAirport', 'areaAirport.airport.cities')
            ->withCount(['cityAirport', 'areaAirport'])#->toSql();
            ->get()
            ->unique('geoNameIdCity')
            ->values()
            ->map(function ($res, $key) {
            return [
                'key' => ++$key,
                'id' => $res->id,
                #'icao' => $res->icao,
                'geoNameIdCity' => $res->geoNameIdCity,
                #'airportName' => $res->airport->name,
                'cityAirportCount' => $res->city_airport_count,
                'cityAirport' => $res->cityAirport->keyBy('icao'),
                'areaAirportCount' => $res->area_airport_count, # - $res->city_airport_count,
                'areaAirportAll' => $res->areaAirport,
                'areaAirport' => $res->areaAirport->keyBy('icao')->diffKeys($res->cityAirport->keyBy('icao')),
                'cityName' => $res->city->name,
                'regionName' => $res->city->regionCountry->name,
                'countryName' => $res->city->country->name,
            ];
        });
    }
/*
    /**
     *  Get the area
     *
     * @param $geoNameIdCity
     *
     * @return AirportArea[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     *
    public function getArea($geoNameIdCity)
    {
        return  $this->with('city', 'city.regionCountry', 'city.country', 'cityAirport', 'areaAirport.airport')
            ->withCount(['cityAirport', 'areaAirport'])
            ->get()
            ->unique('geoNameIdCity')
            ->values()
            ->map(function ($res, $key) {
            return [
                'key' => ++$key,
                'id' => $res->id,
                'icao' => $res->icao,
                'iata' => $res->iata,
                'geoNameIdCity' => $res->geoNameIdCity,
                'airportName' => $res->airport->name,
                'cityAirportCount' => $res->city_airport_count,
                'cityAirport' => $res->cityAirport,
                'airportCount' => $res->area_airport_count - $res->city_airport_count,
                'areaAirport' => $res->areaAirport->diffKeys($res->cityAirport),
                'cityName' => $res->city->name,
                'regionName' => $res->city->regionCountry->name,
                'countryName' => $res->city->country->name,
            ];
        })->where('geoNameIdCity', $geoNameIdCity);
        # ->where('geoNameIdCity', $geoNameIdCity)
    }
    */
}
