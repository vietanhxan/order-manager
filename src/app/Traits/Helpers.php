<?php

namespace VCComponent\Laravel\Order\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use VCComponent\Laravel\Order\Entities\OrderMail;
use VCComponent\Laravel\Order\Facades\Order;
use VCComponent\Laravel\Order\Mail\MailNotify;
use VCComponent\Laravel\Product\Entities\ProductAttribute;

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

    public function ableToUse($user)
    {
        return true;
    }

    public function sendMailOrder($order)
    {
        $email_noti = OrderMail::whereStatus(1)->get();

        foreach ($email_noti as $email) {
            Mail::to($email->email)->queue(new MailNotify($order));
        }

        return $order;
    }
}
