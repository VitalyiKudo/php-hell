<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_id',
        'name',
        'web_site',
        'email',
        'phone',
        'mobile',
        'fax',
        'address',
    ];

}
