<?php

namespace VCComponent\Laravel\Order\Http\Controllers\Web\Cart;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use VCComponent\Laravel\Order\Actions\CartItem\CreateCartItemAction;
use VCComponent\Laravel\Order\Facades\CartItem;
use VCComponent\Laravel\Product\Entities\Product;

class CreateCartItemController extends BaseController
{
    protected $action;

    public function __construct(CreateCartItemAction $action)
    {
        $this->action = $action;
    }

    public function __invoke(Request $request)
    {
        $cart_id       = getCart()->getKey();
        $product_id    = $request->input('product_id');
        $product_price = $request->input('product_price');

        $result = CartItem::where('cart_id', $cart_id)->where('product_id', $product_id)->first();

        if ($result) {
            $product = Product::where('id', $product_id)->first();
            if ($product->quantity == $result->quantity) {
                $quantity = $result->quantity;
                $alert    = 'Số lượng sản phẩm ' . $product->name . ' đã đạt giới hạn ! Sản phẩm đang tồn tại trong giỏ hàng với số lượng = '. $result->quantity ." !";
            } else {
                $quantity = $result->quantity + $request->input('quantity');
            }
        } else {
            $quantity = $request->input('quantity');
        }

        $data = [
            'cart_id'    => $cart_id,
            'product_id' => $product_id,
            'quantity'   => $quantity,
            'price'      => $product_price,
        ];

        $this->action->execute($data);

        if (isset($alert)) {
            $response = back()->with('error', __($alert));
        } else {
            $response = back()->with('messages', __('Sản phẩm đã được thêm vào giỏ hàng'));
            if ($request->has('redirect')) {
                $response = redirect($request->get('redirect'));
            }
        }

        return $response;
    }
}
