<?php

use Illuminate\Support\Facades\Cookie;
use VCComponent\Laravel\Order\Entities\Cart;

if (!function_exists('getCart')) {
    function getCart()
    {
        $cart = [];
        if (Cookie::has('cart')) {
            $cart = Cart::with('cartItems.product')->find(Cookie::get('cart'));
        }
        return $cart;
    }
}
