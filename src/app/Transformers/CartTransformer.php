P<?php

namespace VCComponent\Laravel\Order\Transformers;

use League\Fractal\TransformerAbstract;
use VCComponent\Laravel\Order\Entities\Cart;

class CartTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    public function transform(Cart $model)
    {
        return [
            'id'         => (int) $model->id,
            'total'      => (int) $model->total,
            'timestamps' => [
                'created_at' => $model->created_at,
                'updated_at' => $model->updated_at,
            ],
        ];
    }
}
