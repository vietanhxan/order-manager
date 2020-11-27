<?php

namespace VCComponent\Laravel\Order\Actions\Order;

use VCComponent\Laravel\Order\Actions\Order\CreateOrderItemAction;
use VCComponent\Laravel\Order\Entities\CartItem;
use VCComponent\Laravel\Order\Entities\Order;

class CreateOrderAction
{
    public function __construct(CreateOrderItemAction $createItem, CreateOrderItemAttributesAction $createAttribute, CreateOrderVariantsAction $createVariant)
    {
        $this->createItem      = $createItem;
        $this->createAttribute = $createAttribute;
        $this->createVariant   = $createVariant;
    }

    public function execute(array $data = [])
    {

        $order    = Order::create($data);

        $order_id = [
            'order_id' => $order->id,
        ];


        $cart_id    = $data['cart_id'];


        $cart_items = CartItem::where('cart_id', $cart_id)->get();

        foreach ($cart_items as $cart_item) {
            $data = [
                'product_id' => $cart_item->product_id,
                'quantity'   => $cart_item->quantity,
                'price'      => $cart_item->price,
                'order_id'   => $order->id,
            ];
            $order_item = $this->createItem->excute($data);
            
            foreach ($cart_item->cartProductVariants as $variant) {
                $this->createVariant->excute($order_item, $variant);
            }

        }

        return $order->refresh();
    }
}
