<?php

namespace App\Models;

use App\Providers\Authorize\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $authorize_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $phone_number
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $date_of_birth
 * @property string|null $address
 * @property string|null $gender
 * @property string|null $address_secondary
 * @property string|null $country
 * @property string|null $city
 * @property string|null $state
 * @property string|null $postcode
 * @property string|null $billing_address
 * @property string|null $billing_address_secondary
 * @property string|null $billing_country
 * @property string|null $billing_city
 * @property string|null $billing_state
 * @property string|null $billing_postcode
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cards
 * @property-read int|null $cards_count
 * @property-read string $full_name
 * @property-read string $has_billing_address
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Search[] $searches
 * @property-read int|null $searches_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddressSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAuthorizeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBillingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBillingAddressSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBillingCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBillingCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBillingPostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBillingState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'password',
        'address',
        'address_secondary',
        'country',
        'city',
        'state',
        'postcode',
        'billing_address',
        'billing_address_secondary',
        'billing_country',
        'billing_city',
        'billing_state',
        'billing_postcode',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's billing address state.
     *
     * @return string
     */
    public function getHasBillingAddressAttribute($value)
    {
        return ! is_null($this->billing_address)
            || ! is_null($this->billing_address_secondary)
            || ! is_null($this->billing_country)
            || ! is_null($this->billing_city)
            || ! is_null($this->billing_state)
            || ! is_null($this->billing_postcode);
    }

    /**
     * Get all of the cards for the user.
     */
    public function cards()
    {
        return $this->hasMany('App\Models\Card');
    }

    /**
     * Get all of the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function searches()
    {
        return $this->hasMany('App\Models\Search');
    }

    /**
     * Get all of the transactions for the user.
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }
}
