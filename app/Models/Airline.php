<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_id',
        'type',
        'reg_number',
        'category',
        'homebase',
        'max_pax',
        'yom',
        'operator',
    ];

}
