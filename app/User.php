<?php

namespace App;

use App\Providers\Authorize\Billable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
    
    public function messages(){
        return $this->hasMany('App\Models\Message');
    }
    
    public function rooms(){
        return $this->hasMany('App\Models\Room');
    }
}
