<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_success',
        'transaction_id',
        'amount',
        'message',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_success' => 'boolean',
        'amount' => 'float',
    ];

    /**
     * Get the user of the order.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the order of the order.
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
