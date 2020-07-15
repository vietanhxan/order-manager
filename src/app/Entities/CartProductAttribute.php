<?php

namespace VCComponent\Laravel\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use VCComponent\Laravel\Product\Traits\HasProductTrait;

class CartProductAttribute extends Model
{
    use HasProductTrait;

    protected $fillable = [
        'cart_item_id',
        'product_id',
        'value_id',
    ];
}
