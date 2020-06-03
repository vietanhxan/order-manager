<?php

namespace VCComponent\Laravel\Order\Transformers;

use League\Fractal\TransformerAbstract;
use VCComponent\Laravel\Order\Entities\CartItem;

class CartItemTransformer extends TransformerAbstract
{
    public function transform(CartItem $model)
    {
        return [
            'id'         => (int) $model->id,
            'cart_id'    => (int) $model->cart_id,
            'product_id' => (int) $model->product_id,
            'quantity'   => $model->quantity,
            'price'      => $model->price,
            'item_total' => $model->item_total,
        ];
    }
}
