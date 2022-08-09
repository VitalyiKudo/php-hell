<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;


/**
 * App\Models\Pricing
 *
 * @property int $id
 * @property string|null $source_id
 * @property string $departure
 * @property int $departure_geoId
 * @property string $arrival
 * @property int $arrival_geoId
 * @property string $time_turbo
 * @property string|null $price_turbo
 * @property string|null $time_light
 * @property string|null $price_light
 * @property string|null $time_medium
 * @property string|null $price_medium
 * @property string|null $time_heavy
 * @property string|null $price_heavy
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read City $arrivalCity
 * @property-read City $departureCity
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing whereArrival($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing whereArrivalGeoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing whereDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing whereDepartureGeoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing wherePriceHeavy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing wherePriceLight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing wherePriceMedium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing wherePriceTurbo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing whereTimeHeavy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing whereTimeLight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing whereTimeMedium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing whereTimeTurbo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pricing whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pricing extends Model
{
    use \Awobaz\Compoships\Compoships;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_id',
        'departure',
        'arrival',
        'time_turbo',
        'price_turbo',
        'time_light',
        'price_light',
        'time_medium',
        'price_medium',
        'time_heavy',
        'price_heavy',
        'departure_geoId',
        'arrival_geoId',
    ];

    /**
     * Get the departure of the city.
     */
    public function departureCity()
    {
        return $this->belongsTo(City::class, 'departure_geoId', 'geonameid');
    }

    /**
     * Get the arrival of the city.
     */
    public function arrivalCity()
    {
        return $this->belongsTo(City::class, 'arrival_geoId', 'geonameid');
    }

    public function getPricing()
    {
        return $this
            ->get()
            ->map(fn($value, $key) => [
                'key' => ++$key,
                'id' => $value->id,
                'departure' => $value->departure,
                'arrival' => $value->arrival,
                'price_turbo' => $value->price_turbo,
                'price_light' => $value->price_light,
                'price_medium' => $value->price_medium,
                'price_heavy' => $value->price_heavy,
                'createdAt' => $value->created_at->format('m-d-Y H:i'),
            ]);
    }
}
