<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\City;

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
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read City $operatorCity
 * @method static \Illuminate\Database\Query\Builder|OperatorCity onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorCity whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorCity whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OperatorCity withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OperatorCity withoutTrashed()
 */
class OperatorCity extends Model
{
    use \Awobaz\Compoships\Compoships;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operator_cities';

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
        'email',
        'geoNameIdCity',
        'active',
    ];

    /**
     * Get the operator of the city.
     */
    public function operatorCity()
    {
        return $this->belongsTo(City::class, 'geoNameIdCity', 'geonameid');
    }

}
