<?php

namespace VCComponent\Laravel\Order\Http\Controllers\Web\Cart;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use VCComponent\Laravel\Order\Actions\CartItem\CreateCartItemAction;
use VCComponent\Laravel\Order\Actions\Cart\CreateCartAction;
use VCComponent\Laravel\Order\Entities\CartItem;
use VCComponent\Laravel\Order\Entities\CartProductAttribute;
use VCComponent\Laravel\Order\Entities\CartProductVariant;
use VCComponent\Laravel\Product\Entities\Product;
use VCComponent\Laravel\Product\Entities\ProductAttribute;

class CreateCartItemController extends BaseController
{
    protected $action;

    public function __construct(CreateCartItemAction $action)
    {
        $this->action = $action;
    }

    public function __invoke(Request $request)
    {
        $cart_id       = getCart()->uuid;
        $product_id    = $request->get('product_id');
        $product_price = $request->get('product_price');
        $attributes    = $this->getAttributes($request);

        $data = [
            'cart_id'    => $cart_id,
            'product_id' => $product_id,
            'quantity'   => $request->get('quantity'),
            'price'      => $product_price,
        ];

        $cart_item = $this->action->execute($data, $request);

        if ($attributes != null) {
            foreach ($attributes as $key => $attribute) {
                $data_attributes = [
                    'cart_item_id' => (int) $cart_item->id,
                    'variant_id'   => (int) $attribute,
                    'variant_type' => $request->has('product_type') ? $request->get('product_type') : 'null'
                ];
                CartProductVariant::firstOrCreate($data_attributes);
            }
        }

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

    protected function getAttributes($request)
    {
        $data      = $request->all();
        $cart_data = [
            'quantity'      => $request->get('quantity'),
            'product_id'    => $request->get('product_id'),
            'product_price' => $request->get('product_price'),
        ];

        if ($request->has('redirect')) {
            $cart_data['redirect'] = $request->get('redirect');
        }

        $attributes = array_diff_assoc($data, $cart_data);

        unset($attributes['_token']);
        if(isset($attributes['product_type'])){
            unset($attributes['product_type']);
        }
        return $attributes;
    }

    protected function hasAttributes($data)
    {
        $sold_price = $data['price'];
        if ($data['attributes'] !== null) {
            $product_attributes = ProductAttribute::select('type', 'price')->where('product_id', $data['product_id'])->whereIn('value_id', $data['attributes'])->get();

            $caculate_attributes_price = $product_attributes->sum(function ($q) {
                if ($q->type === 2) {
                    $total = -$q->price;
                } else if ($q->type === 3) {
                    $total = 0;
                } else {
                    $total = $q->price;
                }
                return $total;
            });
            $special_price = $product_attributes->sum(function ($q) {
                return $q->type === 3 ? $q->price : 0;
            });

            if ($special_price !== 0) {
                $sold_price = $special_price + $caculate_attributes_price;
            } else {
                $sold_price = $data['price'] + $caculate_attributes_price;
            }
        }
        return $sold_price;
    }
}
