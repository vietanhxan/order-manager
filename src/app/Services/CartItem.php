<?php

namespace VCComponent\Laravel\Order\Services;

use VCComponent\Laravel\Order\Entities\CartItem as BaseModel;
use VCComponent\Laravel\Order\Traits\OrderQuery;

class CartItem
{
    use OrderQuery;

    public $query;

    public function __construct()
    {
        $this->query = new BaseModel;
    }
}
