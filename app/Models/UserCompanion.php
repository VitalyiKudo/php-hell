<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserCompanion
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $dob
 * @property string|null $email
 * @property string|null $address
 * @property string|null $street_no
 * @property string|null $city
 * @property string|null $state
 * @property string|null $country
 * @property string|null $zipcode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereStreetNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCompanion whereZipcode($value)
 * @mixin \Eloquent
 */
class UserCompanion extends Model
{
    //
}
