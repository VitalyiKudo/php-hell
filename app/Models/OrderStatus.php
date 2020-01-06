<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    /**
     * Get the status style tag.
     *
     * @return string
     */
    public function getStyleAttribute()
    {
        switch ($this->code) {
            case 'on_hold':
                return 'secondary';
            case 'awaiting_payment':
                return 'warning';
            case 'completed':
                return 'success';
            case 'cancelled':
                return 'danger';
         } 

        return 'primary';
    }
}
