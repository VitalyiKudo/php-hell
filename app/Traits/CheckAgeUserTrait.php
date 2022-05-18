<?php
namespace App\Traits;

use Carbon\Carbon;
use Auth;

trait CheckAgeUserTrait {
    /**
     * @return string
     */
    public function CheckAge()
    {
        if(!Auth::check()) {
            $status = 'notAuthorized';
        }
        else {
            $dateAge = (Auth::user()->date_of_birth) ? Auth::user()->date_of_birth->toDateString() : false;
            if ($dateAge) {
                $dt = new Carbon($dateAge);
                $status = (($dt->today()->year - $dt->year) < 18) ? 'notAge' : 'customer';
            } else {
                $status = 'notFilledAge';
            }
        }
        return $status;
    }
}

