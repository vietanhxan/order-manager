<?php

namespace VCComponent\Laravel\Order\Transformers;

use League\Fractal\TransformerAbstract;
use VCComponent\Laravel\Order\Entities\OrderProductVariant;
use VCComponent\Laravel\Product\Transformers\VariantTransformer;

class OrderItemVariantTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'variant'
    ];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    public function transform(OrderProductVariant $model)
    {
        return [
            'id' => (int) $model->id,
            'order_item_id' => $model->order_item_id,
            'variant_type' => $model->variant_type,
            'variant_id' => $model->variant_id,
            'timestamps' => [
                'created_at' => $model->created_at,
                'updated_at' => $model->updated_at,
            ],
        ];
    }

    public function includeVariant(OrderProductVariant $model)
    {
        if ($model->variant) {
            return $this->item($model->variant, new VariantTransformer());
        }
    }

}
