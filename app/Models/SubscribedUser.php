<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubscribedUser
 *
 * @property int $id
 * @property string $email
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscribedUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubscribedUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
    ];
}
