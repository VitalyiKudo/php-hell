<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OperatorJob
 *
 * @property int $id
 * @property string|null $operator
 * @property string|null $name
 * @property string|null $email
 * @property string|null $state
 * @property string|null $city
 * @property string|null $website
 * @property string|null $web_site
 * @property string|null $phone
 * @property string|null $phone2
 * @property string|null $mobile
 * @property string|null $fax
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob query()
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob whereOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob wherePhone2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OperatorJob whereWebsite($value)
 * @mixin \Eloquent
 */
class OperatorJob extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operators_job';
}
