<?php

namespace VCComponent\Laravel\Order\Actions\Order;

use VCComponent\Laravel\Order\Entities\Cart;
use VCComponent\Laravel\Order\Entities\OrderItem;
use VCComponent\Laravel\Product\Entities\Product;

class CreateOrderItemAction
{
    public function excute(array $data = []): OrderItem
    {
        $orderItem = OrderItem::create($data);

        $quantity_sold = $data['quantity'];
        $product_id    = $data['product_id'];

        $product       = Product::where('id', $product_id)->first();
        $quantity_left = $product->quantity - $quantity_sold;

        Product::where('id', $product_id)->update([
            'quantity'      => $quantity_left,
            'sold_quantity' => $product->sold_quantity + $quantity_sold,
        ]);

        return $orderItem->refresh();
    }

}
