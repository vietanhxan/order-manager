<?php

namespace VCComponent\Laravel\Order\Services;

use Illuminate\Support\Str;
use VCComponent\Laravel\Order\Entities\Cart as BaseModel;
use VCComponent\Laravel\Order\Traits\OrderQuery;

class Cart
{
    use OrderQuery;

    public $query;

    public function __construct()
    {
        $this->query = new BaseModel;
    }

    public function generateUuid()
    {
        return Str::uuid()->toString();
    }
}
