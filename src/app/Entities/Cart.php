<?php

namespace VCComponent\Laravel\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use VCComponent\Laravel\Order\Entities\CartItem;

class Cart extends Model
{
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'total',
    ];

    public $incrementing = false;

    protected $keyType = 'int';

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'uuid');
    }

    public function calculateTotal(): int
    {
        return $this->cartItems->sum('amount');
    }

    public function cartTypes()
    {
        return [
            'cart',
        ];
    }

    public function viewCartItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'uuid')->with('product', 'itemAttributes');
    }

    public static function generateUuid()
    {
        return Str::uuid()->toString();
    }
}
