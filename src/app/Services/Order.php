<?php

namespace VCComponent\Laravel\Order\Services;

use VCComponent\Laravel\Order\Entities\Order as BaseModel;
use VCComponent\Laravel\Order\Traits\OrderQuery;

class Order
{
    use OrderQuery;

    public $query;

    public function __construct()
    {
        $this->query = new BaseModel;
    }
}
