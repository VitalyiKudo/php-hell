<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'source_id',
        'departure',
        'arrival',
        'time_turbo',
        'price_turbo',
        'time_light',
        'price_light',
        'time_medium',
        'price_medium',
        'time_heavy',
        'price_heavy',
    ];

}
