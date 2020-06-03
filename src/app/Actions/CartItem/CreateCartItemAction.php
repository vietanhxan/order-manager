<?php

namespace VCComponent\Laravel\Order\Actions\CartItem;

use VCComponent\Laravel\Order\Actions\CartItem\CalculateCartItemAmountAction;
use VCComponent\Laravel\Order\Actions\Cart\CalculateCartTotalAction;
use VCComponent\Laravel\Order\Facades\CartItem;

class CreateCartItemAction
{
    protected $calculateCartItemAmountAction;
    protected $calculateCartTotalAction;

    public function __construct(
        CalculateCartItemAmountAction $calculateCartItemAmountAction,
        CalculateCartTotalAction      $calculateCartTotalAction
    ) {
        $this->calculateCartItemAmountAction = $calculateCartItemAmountAction;
        $this->calculateCartTotalAction      = $calculateCartTotalAction;
    }

    public function execute(array $data)
    {
        $result = CartItem::where('cart_id', $data['cart_id'])->where('product_id', $data['product_id'])->first();

        if ($result) {
            $result->delete();
            $cartItem = CartItem::create($data);
        } else {
            $cartItem = CartItem::create($data);
        }

        $this->calculateCartItemAmountAction->execute($cartItem);

        $this->calculateCartTotalAction->execute($cartItem->cart);

        return $cartItem->refresh();
    }
}
