<?php

namespace VCComponent\Laravel\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderProductAttribute extends Model
{
    protected $fillable = [
        'order_item_id',
        'product_id',
        'value_id',
    ];
}
