<?php

namespace VCComponent\Laravel\Order\Http\Controllers\Web\Cart;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use VCComponent\Laravel\Order\Actions\CartItem\DeleteCartItemAction;

class DeleteCartItemController extends BaseController
{
    protected $action;

    public function __construct(DeleteCartItemAction $action)
    {
        $this->action = $action;
    }

    public function __invoke($id)
    {
        $this->action->execute($id);
        return redirect('cart');
    }
}
