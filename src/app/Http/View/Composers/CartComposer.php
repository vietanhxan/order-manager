<?php

namespace VCComponent\Laravel\Order\Http\View\Composers;

use Illuminate\View\View;

class CartComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $cart           = getCart();

        $cartItemsCount = 0;

        if ($cart) {
            $cartItemsCount = $cart->cartItems->count();
        }

        $view->with('cartItemsCount', $cartItemsCount);
    }
}
