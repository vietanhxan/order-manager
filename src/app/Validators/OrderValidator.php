<?php

namespace VCComponent\Laravel\Order\Validators;

use VCComponent\Laravel\Vicoders\Core\Validators\AbstractValidator;
use VCComponent\Laravel\Vicoders\Core\Validators\ValidatorInterface;

class OrderValidator extends AbstractValidator
{
    protected $rules = [
        ValidatorInterface::RULE_ADMIN_CREATE  => [
            'user_id'        => ['required'],
            'email'          => ['bail', 'required', 'email'],
            'username'       => ['required'],
            'phone_number'   => ['required'],
            'address'        => ['required', 'alpha_dash'],
            'order_note'     => ['required'],
            'payment_method' => ['required'],
        ],
        ValidatorInterface::RULE_ADMIN_UPDATE  => [
            'user_id'        => ['required'],
            'email'          => ['bail', 'required', 'email'],
            'username'       => ['required'],
            'phone_number'   => ['required'],
            'address'        => ['required', 'alpha_dash'],
            'order_note'     => ['required'],
            'payment_method' => ['required'],
        ],
        ValidatorInterface::RULE_CREATE        => [
            'user_id'        => ['required'],
            'email'          => ['bail', 'required', 'email'],
            'username'       => ['required'],
            'phone_number'   => ['required'],
            'address'        => ['required', 'alpha_dash'],
            'order_note'     => ['required'],
            'payment_method' => ['required'],
        ],
        ValidatorInterface::UPDATE_STATUS_ITEM => [
            'status' => ['required'],
        ],
        "UPDATE_PAYMENT_STATUS"                => [
            'payment_status' => ['required'],
        ],
        "CREATE_ORDER_ITEM"                    => [
            'product_id' => ['required'],
            'quantity'   => ['required'],
        ],
    ];
}
