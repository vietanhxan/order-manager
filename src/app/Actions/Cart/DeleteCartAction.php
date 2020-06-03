<?php

namespace VCComponent\Laravel\Order\Actions\Cart;

use VCComponent\Laravel\Order\Actions\CartItem\DeleteCartItemAction;
use VCComponent\Laravel\Order\Facades\Cart;

class DeleteCartAction
{
    protected $deleteItemAction;

    public function __construct(DeleteCartItemAction $deleteItemAction)
    {
        $this->deleteItemAction = $deleteItemAction;
    }

    public function execute(string $id): void
    {
        $cart = Cart::findOrFail($id);
        if ($cart->cartItems->count()) {
            $cart->cartItems->each(function ($item) {
                $this->deleteItemAction->execute($item->id);
            });
        }
        $cart->delete();
    }
}
