<?php

namespace VCComponent\Laravel\Order\Facades;

use Illuminate\Support\Facades\Facade;

class OrderMail extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'orderMail';
    }
}
