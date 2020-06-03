<?php

use Faker\Generator;
use VCComponent\Laravel\Order\Entities\CartItem;

$factory->define(CartItem::class, function (Generator $faker) {
    return [
        'cart_id'       => 1,
        'cartable_id'   => 1,
        'cartable_type' => 'products',
        'quantity'      => 1,
        'item_price'    => 2000,
    ];
});
