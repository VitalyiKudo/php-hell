<?php

namespace App\Providers\Helpdeskeddy\Facades;

use Illuminate\Support\Facades\Facade;

class Helpdeskeddy extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'helpdeskeddy';
    }
}
