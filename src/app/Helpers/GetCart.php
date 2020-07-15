<?php

use VCComponent\Laravel\Order\Facades\GetCart;

if (!function_exists('getCart')) {
    function getCart()
    {
        return GetCart::getCart();
    }
}
