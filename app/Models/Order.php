<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment',
        'price',
        'billing_address',
        'billing_address_secondary',
        'billing_country',
        'billing_city',
        'billing_province',
        'billing_postcode',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
    ];

    /**
     * Get the user of the order.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the status of the order.
     */
    public function status()
    {
        return $this->belongsTo('App\Models\OrderStatus', 'order_status_id');
    }

    /**
     * Get the search result of the order.
     */
    public function search_result()
    {
        return $this->belongsTo('App\Models\SearchResult', 'search_result_id');
    }
}
