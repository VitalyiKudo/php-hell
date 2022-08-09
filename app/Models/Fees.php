<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Fees
 *
 * @property int $id
 * @property string $item
 * @property string $amount
 * @property string $type
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $sall
 * @method static \Illuminate\Database\Eloquent\Builder|Fees newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fees newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fees query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fees whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fees whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fees whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fees whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fees whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fees whereSall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fees whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fees whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Fees extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'item',
        'amount',
        'type',
        'active',
    ];

    public const IS_SALL = 1;
    public const IS_NOT_SALL = 0;

    public function getFees()
    {
        return $this
            ->get()
            ->map(fn($value, $key) => [
                'key' => ++$key,
                'id' => $value->id,
                'item' => $value->item,
                'amount' => $value->amount,
                'type' => $value->type,
                'active' => $value->active,
                'sall' => $value->sall,
                'createdAt' => $value->created_at->format('m-d-Y H:i'),
            ]);
    }
}
