<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int $order_status_id
 * @property int $search_result_id
 * @property string|null $comment
 * @property float $price
 * @property string $billing_address
 * @property string|null $billing_address_secondary
 * @property string $billing_country
 * @property string $billing_city
 * @property string|null $billing_province
 * @property string $billing_postcode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $is_accepted
 * @property string|null $type
 * @property int|null $book_status
 * @property string|null $payment_id
 * @property-read \App\Models\Search $searches
 * @property-read \App\Models\OrderStatus $status
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingAddressSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingPostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBookStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIsAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSearchResultId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @mixin \Eloquent
 */
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
        'order_status_id',
        'search_result_id',
        'billing_address',
        'billing_address_secondary',
        'billing_country',
        'billing_city',
        'billing_province',
        'billing_postcode',
        'is_accepted'
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
        return $this->belongsTo('App\Models\User');
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
    public function searches()
    {
        return $this->belongsTo('App\Models\Search', 'search_result_id');
    }
}
