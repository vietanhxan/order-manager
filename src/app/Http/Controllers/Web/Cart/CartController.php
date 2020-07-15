<?php

namespace VCComponent\Laravel\Order\Http\Controllers\Web\Cart;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use VCComponent\Laravel\Order\Contracts\ViewCartControllerInterface;
use VCComponent\Laravel\Order\Traits\Helpers;
use VCComponent\Laravel\Order\ViewModels\Cart\CartViewModel;

class CartController extends BaseController implements ViewCartControllerInterface
{
    use Helpers;

    public function __construct()
    {
        if (isset(config('order.viewModels')['cart'])) {
            $this->ViewModel = config('order.viewModels.cart');
        } else {
            $this->ViewModel = CartViewModel::class;
        }
    }

    public function index(Request $request)
    {
        $type = $this->getTypeCart($request);

        $cart = getCart();

        $custom_view_data = $this->viewData($cart, $request);

        $view_model = new $this->ViewModel($cart);
        $data       = array_merge($custom_view_data, $view_model->toArray());

        return view($this->view(), $data);

    }

    protected function view()
    {
        return 'pages.cart';
    }

    protected function viewData($cart, Request $request)
    {
        return [];
    }
}
