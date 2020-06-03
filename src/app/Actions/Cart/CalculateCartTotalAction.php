<?php

namespace VCComponent\Laravel\Order\Actions\Cart;

use VCComponent\Laravel\Order\Entities\Cart;

class CalculateCartTotalAction
{
    public function execute(Cart $cart): Cart
    {
        $total = $cart->calculateTotal();

        $cart->fill(['total' => $total])->save();

        return $cart->refresh();
    }
}
