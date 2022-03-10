<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message', 'room_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function administrator(){
        return $this->belongsTo(Administrator::class);
    }
    public function room(){
        return $this->belongsTo(Room::class);
    }
}
