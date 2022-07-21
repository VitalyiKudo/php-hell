<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $key
 * @property string $title
 * @property string $channel
 * @property string $message
 */
class Notification extends Model
{
    protected $table = 'notifications';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'message',
    ];

    public const ORDER_UPDATE_NOTIFICATION_ID = 1;
    public const REQUEST_UPDATE_NOTIFICATION_ID = 2;

    public const FLUTTER_NOTIFICATION_CLICK = 'FLUTTER_NOTIFICATION_CLICK';
}
