<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function administrators()
    {
        return $this->belongsToMany(Administrator::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }
}
