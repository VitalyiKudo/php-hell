<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
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
        'is_accepted',
        'type',
        'book_status',
        'payment_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
    ];

    public static function new(int $userId, int $statusId, int $resultId, string $comment, string $type, int $bookStatus): self
    {
        $order = new self();
        $order->user_id = $userId;
        $order->order_status_id = $statusId;
        $order->search_result_id = $resultId;
        $order->comment = $comment;
        $order->type = $type;
        $order->book_status = $bookStatus;

        $order->save();

        return $order;
    }

    /**
     * @param $data
     *
     * @return Order|Model|m.\App\Models\Order.create
     */
    public function createOrder ($data)
    {
        return $this->firstOrCreate(
            [
                'user_id' => $data['user_id'],
                'search_result_id' => $data['search_result_id']
            ],
            [
                 'user_id' => $data['user_id'] ?? 0,
                 'comment' => $data['comment'] ?? '',
                 'price' => $data['price'] ?? 0,
                 'order_status_id' => $data['order_status_id'] ?? 1,
                 'search_result_id' => $data['search_result_id'] ?? 0,
                 'billing_address' => $data['billing_address'] ?? '',
                 'billing_address_secondary' => $data['billing_address_secondary'] ?? '',
                 'billing_country' => $data['billing_country'] ?? '',
                 'billing_city' => $data['billing_city'] ?? '',
                 'billing_province' => $data['billing_province'] ?? '',
                 'billing_postcode' => $data['billing_postcode'] ?? '',
                 'is_accepted' => $data['is_accepted'] ?? 0,
                 'type' => $data['type'] ?? '',
                 'book_status' => $data['book_status'] ?? 1,
                 'payment_id' => $data['payment_id'] ?? ''
            ]);
    }

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
        return $this->belongsTo(Search::class, 'search_result_id', 'id');
    }

    public function getMappedOrders()
    {
        return $this
            ->get()
            ->map(fn($value, $key) => [
                'key' => ++$key,
                'id' => $value->id,
                'user' => is_null($value->user) ? null : $value->user->full_name,
                'userId' => is_null($value->user) ? null : $value->user->id,
                'orderStatus' => $value->status->name,
                'orderStatusStyle' => $value->status->style,
                'isAccepted' => $value->is_accepted,
                'price' => $value->price,
                'createdAt' => $value->created_at->format('m-d-Y H:i'),
            ]);
    }

    public function getOrders($id = false)
    {
        return  $this->with('searches', 'status', 'user')
            ->where(function ($query) use ($id) {
                if (!empty($id)) {
                    $query->where('id', $id);
                }
            })
            ->orderByDesc('id')
            ->get()
            #->first();
            ->values()
            ->map(fn($value, $key) => [
                'key' => ++$key,
                'id' => $value->id,
                'user' => $value->user->first_name.' '.$value->user->last_name,
                'status' => $value->status->name,
                'statusBg' => $value->status->id,
                'price' => $value->price,
                'created' => $value->created_at, # - $res->city_airport_count,
                'seacrh' => $value->searches, # - $res->city_airport_count,
            ])
            ->sortBy('key');
    }
}
