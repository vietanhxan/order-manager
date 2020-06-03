<?php

namespace VCComponent\Laravel\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use VCComponent\Laravel\Order\Traits\Helpers;
use VCComponent\Laravel\Product\Entities\Product;

class OrderItem extends Model
{
    use Helpers;

    const STATUS_PENDING = 0;
    const STATUS_ACTIVE  = 1;

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
