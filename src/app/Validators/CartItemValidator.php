<?php

namespace VCComponent\Laravel\Order\Validators;

use VCComponent\Laravel\Vicoders\Core\Validators\AbstractValidator;

class CartItemValidator extends AbstractValidator
{
    protected $rules = [
        "CHANGE_QUANTITY" => [
            'quantity' => ['required'],
        ],
    ];
}
