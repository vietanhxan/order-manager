<?php

namespace VCComponent\Laravel\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use VCComponent\Laravel\Order\Entities\Cart;
use VCComponent\Laravel\Order\Entities\CartProductAttribute;
use VCComponent\Laravel\Order\Traits\HasCartProductAttributes;
use VCComponent\Laravel\Product\Entities\Product;
use VCComponent\Laravel\Order\Entities\CartProductVariant;
use VCComponent\Laravel\Order\Traits\HasCartProductVariants;

class CartItem extends Model
{
    use HasCartProductAttributes;
    use HasCartProductVariants;

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

    public function cartProductVariants()
    {
        return $this->hasOne(CartProductVariant::class, 'cart_item_id');
    }
}
