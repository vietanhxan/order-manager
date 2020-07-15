<?php

namespace VCComponent\Laravel\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use VCComponent\Laravel\Order\Entities\Cart;
use VCComponent\Laravel\Order\Entities\CartProductAttribute;
use VCComponent\Laravel\Order\Traits\HasCartProductAttributes;
use VCComponent\Laravel\Product\Entities\Product;

class CartItem extends Model
{
    use HasCartProductAttributes;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
        'amount',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'uuid');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function calculateAmount(): int
    {
        return $this->quantity * $this->price;
    }

    public function cartProductAttributes()
    {
        return $this->hasMany(CartProductAttribute::class);
    }
}
