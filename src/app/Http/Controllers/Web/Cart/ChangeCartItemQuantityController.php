<?php

namespace VCComponent\Laravel\Order\Http\Controllers\Web\Cart;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use VCComponent\Laravel\Order\Actions\CartItem\ChangeCartItemQuantityAction;

class ChangeCartItemQuantityController extends BaseController
{
    protected $action;

    public function __construct(ChangeCartItemQuantityAction $action)
    {
        $this->action = $action;
    }

    public function __invoke($id, Request $request)
    {
        $data = [
            'id'       => $id,
            'quantity' => $request->input('quantity'),
        ];

        $this->action->execute($data);

        return redirect('cart');
    }
}
