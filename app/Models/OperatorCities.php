<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OperatorCities
 *
 * @property int $id
 * @property string|null $email
 * @property int $geoNameIdCity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorCities newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorCities newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorCities query()
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorCities whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorCities whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorCities whereGeoNameIdCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorCities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorCities whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OperatorCities extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operator_cities';
    #public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'geoNameIdCity',
    ];

    /**
     * Get the operator of the city.
     */
    public function operatorCity()
    {
        return $this->belongsTo(City::class,  'geonameid', 'geoNameIdCity');
    }

    /**
     * Get the operator of the region.
     */
    public function operatorRegion()
    {
        return $this->belongsTo(Region::class, ['iso_country', 'iso_region'], ['country_id', 'region_id']);
    }
}
