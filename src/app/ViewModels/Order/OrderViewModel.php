<?php

namespace VCComponent\Laravel\Order\ViewModels\Order;

use VCComponent\Laravel\ViewModel\ViewModels\BaseViewModel;

class OrderViewModel extends BaseViewModel
{
    public $carts;

    public function __construct($carts)
    {
        $this->carts = $carts;
    }
}
