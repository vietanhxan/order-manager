<?php

namespace VCComponent\Laravel\Order\Actions\Order;

use VCComponent\Laravel\Order\Entities\OrderProductVariant;

class CreateOrderVariantsAction
{
    public function excute($order_item, $cart_attribute)
    {
        $data = [
            'order_item_id' => $order_item->id,
            'variant_id'    => $cart_attribute->variant_id,
            'variant_type'  => $cart_attribute->variant_type,
        ];

        $order_variant = OrderProductVariant::create($data);

        return $order_variant->refresh();
    }

}
