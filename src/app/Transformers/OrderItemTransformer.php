<?php

namespace VCComponent\Laravel\Order\Transformers;

use League\Fractal\TransformerAbstract;
use VCComponent\Laravel\Order\Entities\OrderItem;
use VCComponent\Laravel\Order\Transformers\OrderItemVariantTransformer;
use VCComponent\Laravel\Product\Transformers\ProductTransformer;

class OrderItemTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'product', 'variants'
    ];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    public function transform(OrderItem $model)
    {
        return [
            'id'         => (int) $model->id,
            'product_id' => (int) $model->product_id,
            'quantity'   => $model->quantity,
            'price'      => $model->price,
            'cart_id'    => $model->cart_id,
            'timestamps' => [
                'created_at' => $model->created_at,
                'updated_at' => $model->updated_at,
            ],
        ];
    }

    public function includeProduct(OrderItem $model)
    {
        return $this->item($model->product, new ProductTransformer());
    }

    public function includeVariants($model) 
    {
        return $this->collection($model->orderItemVariant, new OrderItemVariantTransformer());
    }
}
