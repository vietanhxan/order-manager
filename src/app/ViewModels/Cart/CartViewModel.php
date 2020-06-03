<?php

namespace VCComponent\Laravel\Order\ViewModels\Cart;

use VCComponent\Laravel\ViewModel\ViewModels\BaseViewModel;

class CartViewModel extends BaseViewModel
{
    public $carts;

    public function __construct($carts)
    {
        $this->carts = $carts;
    }
}
