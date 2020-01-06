<?php

namespace App\Providers\Authorize\Facades;

use Illuminate\Support\Facades\Facade;

class Authorize extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'authorize';
    }
}
