<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Airline
 *
 * @property int $id
 * @property string|null $source_id
 * @property string $type
 * @property string $reg_number
 * @property string $category
 * @property string $homebase
 * @property string|null $max_pax
 * @property string|null $yom
 * @property string $operator
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Airline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Airline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Airline query()
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereHomebase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereMaxPax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereRegNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereYom($value)
 * @mixin \Eloquent
 */
class Airline extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_id',
        'type',
        'reg_number',
        'category',
        'homebase',
        'max_pax',
        'yom',
        'operator',
    ];

}
