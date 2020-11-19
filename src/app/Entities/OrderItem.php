<?php

namespace VCComponent\Laravel\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use VCComponent\Laravel\Order\Traits\Helpers;
use VCComponent\Laravel\Product\Entities\Product;

class OrderItem extends Model
{

    protected $fillable = [
        'product_id',
        'quantity',
        'price',
        'order_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
