<?php

namespace VCComponent\Laravel\Order\Validators;

use VCComponent\Laravel\Vicoders\Core\Validators\AbstractValidator;
use VCComponent\Laravel\Vicoders\Core\Validators\ValidatorInterface;

class OrderMailValidator extends AbstractValidator
{
    protected $rules = [
        ValidatorInterface::RULE_ADMIN_CREATE  => [
            'email' => ['required', 'email'],
        ],
        ValidatorInterface::RULE_ADMIN_UPDATE  => [
            'email' => ['required', 'email'],
        ],
        ValidatorInterface::UPDATE_STATUS_ITEM => [
            'status' => ['required'],
        ],
    ];
}
