<?php

namespace VCComponent\Laravel\Order\Actions\Order;

use VCComponent\Laravel\Order\Actions\Order\CreateOrderItemAction;
use VCComponent\Laravel\Order\Entities\CartItem;
use VCComponent\Laravel\Order\Entities\Order;
// use VCComponent\Laravel\Order\Entities\UserOrders;

class CreateOrderAction
{
    public function __construct(CreateOrderItemAction $createItem, CreateOrderItemAttributesAction $createAttribute)
    {
        $this->createItem      = $createItem;
        $this->createAttribute = $createAttribute;
    }

    public function execute(array $data = [])
    {
        $attributes = collect($data)
            ->only(['phone_number', 'total'])
            ->toArray();

        $order    = Order::firstOrCreate($attributes, $data);
        $order_id = [
            'order_id' => $order->id,
        ];

        // $user = UserOrders::firstOrCreate($order_id);

        // Order::where('id', $order->id)->update(['user_id' => $user->id]);

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

            foreach ($cart_item->cartProductAttributes as $item) {
                $this->createAttribute->excute($order_item, $item);
            }

        }

        return $order->refresh();
    }
}
