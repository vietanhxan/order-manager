<?php

namespace VCComponent\Laravel\Order\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait Helpers
{
    private function getTypeCart($request)
    {
        if (config('order.models.cart') !== null) {
            $model_class = config('order.models.cart');
        } else {
            $model_class = \VCComponent\Laravel\Order\Entities\Cart::class;
        }
        $model      = new $model_class;
        $cartTypes  = $model->cartTypes();
        $path_items = collect(explode('/', $request->path()));
        $type       = 'order';

        foreach ($cartTypes as $value) {
            foreach ($path_items as $item) {
                if ($value === $item) {
                    $type = $value;
                }
            }
        }

        return $type;
    }

    private function getTypeOrder($request)
    {
        if (config('order.models.order') !== null) {
            $model_class = config('order.models.order');
        } else {
            $model_class = \VCComponent\Laravel\Order\Entities\Order::class;
        }
        $model      = new $model_class;
        $orderTypes = $model->orderTypes();
        $path_items = collect(explode('/', $request->path()));
        $type       = 'order';

        foreach ($orderTypes as $value) {
            foreach ($path_items as $item) {
                if ($value === $item) {
                    $type = $value;
                }
            }
        }

        return $type;
    }

    public function ableToUse($user)
    {
        return true;
    }
}
