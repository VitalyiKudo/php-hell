<?php
namespace App\Traits;

use Illuminate\Support\Facades\Config;

trait EmptyLegStatusTrait {

    /**
     * @param $status
     *
     * @return int|string
     */
    public function status ($status) {
        $active = 'Not activated';
        foreach (Config::get("constants.active") as $key => $value) {
            if ($value === (int)$status){
                $active = $key;
            }
        }
        return $active;
    }

    /***
     * @param $status
     *
     * @return int|string
     */
    public function statusBg ($status) {
        $active = 'bg-secondary';
        foreach (Config::get("constants.active_bg") as $key => $value) {
            if ($value === (int)$status){
                $active = $key;
            }
        }
        return $active;
    }
}

