<?php

namespace VCComponent\Laravel\Order\Http\View\Composers;

use Illuminate\View\View;
use VCComponent\Laravel\Order\Entities\Cart;

class CartAttributesComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $cart                = getCart();
        $cartItemsCount      = 0;
        $attributeItemsCount = 0;
        if ($cart) {
            foreach ($cart->cartItems as $cartItem) {
                $attributeItemsCount = $cartItem->itemAttributes->count();
            }
        }
        $view->with('attributeItemsCount', $attributeItemsCount);
    }
}
