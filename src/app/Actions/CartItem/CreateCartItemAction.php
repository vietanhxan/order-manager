<?php

namespace VCComponent\Laravel\Order\Actions\CartItem;

use VCComponent\Laravel\Order\Actions\CartItem\CalculateCartItemAmountAction;
use VCComponent\Laravel\Order\Actions\Cart\CalculateCartTotalAction;
use VCComponent\Laravel\Order\Entities\CartItem;
use VCComponent\Laravel\Product\Entities\Product;

class CreateCartItemAction
{
    protected $calculateCartItemAmountAction;
    protected $calculateCartTotalAction;

    public function __construct(
        CalculateCartItemAmountAction $calculateCartItemAmountAction,
        CalculateCartTotalAction      $calculateCartTotalAction
    ) {
        $this->calculateCartItemAmountAction = $calculateCartItemAmountAction;
        $this->calculateCartTotalAction      = $calculateCartTotalAction;
    }

    public function execute(array $data, $request)
    {
        $items = CartItem::where(['cart_id' => $data['cart_id'], 'product_id' => $data['product_id']])->get();

        if (array_key_exists('attributes', $data) && $items->count()) {

            $attributes_in_cart = $items->map(function ($q) {
                return $q->itemAttributes->pluck('value_id')->toArray();
            });

            $new_attributes = collect($data['attributes'])->map(function ($q) {
                return (int) $q;
            })->values();

            $found = $attributes_in_cart->search(function ($q) use ($new_attributes) {
                return $q === $new_attributes->toArray();
            });

            if ($found === false) {
                $cartItem = CartItem::create($data);
            } else {
                $get_found = $attributes_in_cart->get($found);

                $item = $items->filter(function ($q) use ($get_found) {
                    return $q->itemAttributes->pluck('value_id')->toArray() === $get_found;
                })->first();
                $data['quantity'] = $this->caculateQuantity($request, $item);
                $item->delete();
                $cartItem = CartItem::create($data);
            }
        } else {
            $old_items        = CartItem::where('cart_id', $data['cart_id'])->where('product_id', $data['product_id'])->first();
            $data['quantity'] = $this->caculateQuantity($request, $old_items);
            if ($old_items) {
                $old_items->delete();
                $cartItem = CartItem::create($data);
            } else {
                $cartItem = CartItem::create($data);
            }
        }

        $this->calculateCartItemAmountAction->execute($cartItem);

        $this->calculateCartTotalAction->execute($cartItem->cart);

        return $cartItem->refresh();
    }

    protected function caculateQuantity($request, $old_items)
    {
        if ($old_items) {
            $product = Product::where('id', $request->get('product_id'))->first();
            if ($product->quantity == $old_items->quantity) {
                $quantity = $old_items->quantity;
                $alert    = 'Số lượng sản phẩm ' . $product->name . ' đã đạt giới hạn ! Sản phẩm đang tồn tại trong giỏ hàng với số lượng = ' . $old_items->quantity . " !";
            } else {
                $quantity = $old_items->quantity + $request->get('quantity');
            }
        } else {
            $quantity = $request->get('quantity');
        }

        return $quantity;
    }
}
