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
 */
class AirportAreas extends Model
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
        return $this->belongsTo(Airport::class, 'icao', 'icao');
    }

    /**
     * Get the area of the city.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'geoNameIdCity', 'geonameid');
    }
}
