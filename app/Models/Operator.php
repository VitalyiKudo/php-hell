<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Operator
 *
 * @property int $id
 * @property string|null $source_id
 * @property string $name
 * @property string $web_site
 * @property string $email
 * @property string $phone
 * @property string $mobile
 * @property string $fax
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Operator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Operator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Operator query()
 * @method static \Illuminate\Database\Eloquent\Builder|Operator whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operator whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operator whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operator whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operator whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operator wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operator whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operator whereWebSite($value)
 * @mixin \Eloquent
 * @property string|null $state
 * @property string|null $city
 * @method static \Illuminate\Database\Eloquent\Builder|Operator whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Operator whereState($value)
 */
class Operator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_id',
        'name',
        'web_site',
        'email',
        'phone',
        'mobile',
        'fax',
        'address',
    ];

}
