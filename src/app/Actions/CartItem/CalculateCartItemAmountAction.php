<?php

namespace VCComponent\Laravel\Order\Actions\CartItem;

use VCComponent\Laravel\Order\Entities\CartItem;

class CalculateCartItemAmountAction
{
    public function execute(CartItem $cartItem): CartItem
    {
        $amount = $cartItem->calculateAmount();
        $cartItem->fill(['amount' => $amount])->save();

        return $cartItem->refresh();
    }
}
