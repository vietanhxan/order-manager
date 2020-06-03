<?php

namespace VCComponent\Laravel\Order\Actions\CartItem;

use VCComponent\Laravel\Order\Actions\CartItem\CalculateCartItemAmountAction;
use VCComponent\Laravel\Order\Actions\Cart\CalculateCartTotalAction;
use VCComponent\Laravel\Order\Facades\CartItem;

class ChangeCartItemQuantityAction
{
    protected $calculateCartItemAmountAction;
    protected $calculateCartTotalAction;

    public function __construct(CalculateCartItemAmountAction $calculateCartItemAmountAction, CalculateCartTotalAction $calculateCartTotalAction)
    {

        $this->calculateCartItemAmountAction = $calculateCartItemAmountAction;
        $this->calculateCartTotalAction      = $calculateCartTotalAction;
    }

    public function execute(array $data)
    {
        $cartItem = CartItem::findOrFail($data['id']);

        $cartItem->fill(['quantity' => $data['quantity']])->save();

        $this->calculateCartItemAmountAction->execute($cartItem);
        $this->calculateCartTotalAction->execute($cartItem->cart);

        return $cartItem->refresh();
    }
}
