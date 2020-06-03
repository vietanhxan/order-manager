<?php

namespace VCComponent\Laravel\Order\Http\Controllers\Api\Fontend\Cart;

use Illuminate\Http\Request;
use VCComponent\Laravel\Order\Actions\CartItem\ChangeCartItemQuantityAction;
use VCComponent\Laravel\Order\Facades\Cart;
use VCComponent\Laravel\Order\Facades\CartItem;
use VCComponent\Laravel\Order\Repositories\CartItemRepository;
use VCComponent\Laravel\Order\Validators\CartItemValidator;
use VCComponent\Laravel\Product\Entities\Product;
use VCComponent\Laravel\Vicoders\Core\Controllers\ApiController;

class CartItemController extends ApiController
{
    protected $repository;
    protected $validator;

    public function __construct(CartItemRepository $repository, CartItemValidator $validator, ChangeCartItemQuantityAction $action)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->action     = $action;
    }

    public function changeQuantity(Request $request, $id)
    {
        $this->validator->isValid($request, 'CHANGE_QUANTITY');

        $this->repository->findById($id);

        $data = [
            'id'       => $id,
            'quantity' => $request->input('quantity'),
        ];

        $cartItem = CartItem::findOrFail($id);
        $cart     = Cart::where('id', $cartItem->cart_id)->first();
        $product  = Product::where('id', $cartItem->product_id)->first();

        $error = '';

        if ($product->quantity < $request->input('quantity')) {
            $error = 'Số lượng của sản phẩm '. $product->name .' đã đạt đến giới hạn ! Bạn vẫn có thể đặt hàng nhưng với số lượng tối đa của sản phẩn này là : '. $product->quantity . ' . Xin lỗi vì sự bất tiện này !';
            return response()->json(['result' => $cartItem, 'cart' => $cart , 'error' => $error]);
        }

        $cartItemAfter = $this->action->execute($data);
        $cartAfter     = Cart::where('id', $cartItem->cart_id)->first();
        return response()->json(['result' => $cartItemAfter, 'cart' => $cartAfter, 'error' => $error]);
    }

}
