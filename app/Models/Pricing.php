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
        'time',
        'price_turbo',
        'price_light',
        'price_medium',
        'price_heavy',
    ];

}
