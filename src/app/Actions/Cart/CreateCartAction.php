<?php

namespace VCComponent\Laravel\Order\Actions\Cart;

use Illuminate\Support\Facades\Cookie;
use VCComponent\Laravel\Order\Actions\CartItem\CreateCartItemAction;
use VCComponent\Laravel\Order\Facades\Cart;

class CreateCartAction
{
    protected $createItemAction;
    protected $calculateTotalAction;

    public function __construct(
        CreateCartItemAction     $createItemAction,
        CalculateCartTotalAction $calculateTotalAction
    ) {
        $this->createItemAction     = $createItemAction;
        $this->calculateTotalAction = $calculateTotalAction;
    }

    public function execute(array $data = [])
    {
        $cart = Cart::create([
            'id' => Cart::generateUuid(),
        ]);

        if (count($data)) {
            $items = $data['items'];
            collect($items)->each(function ($item) use ($cart) {
                $itemData = array_merge(['cart_id' => $cart->getKey()], $item);
                $this->createItemAction->execute($itemData);
            });
        }

        $this->calculateTotalAction->execute($cart->refresh());

        return $cart->refresh();
    }
}
