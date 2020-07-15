<?php

namespace VCComponent\Laravel\Order\Transformers;

use League\Fractal\TransformerAbstract;
use VCComponent\Laravel\Order\Entities\Order;

class OrderMailTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

    public function __construct($includes = [])
    {
        $this->setDefaultIncludes($includes);
    }

    public function transform($model)
    {
        return [
            'id'         => (int) $model->id,
            'email'      => $model->email,
            'status'     => $model->status,
            'timestamps' => [
                'created_at' => $model->created_at,
                'updqted_at' => $model->updated_at,
            ],
        ];
    }
}
