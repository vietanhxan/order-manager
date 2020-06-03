<?php

namespace VCComponent\Laravel\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class UserOrders extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_ACTIVE  = 1;

    protected $fillable = [
        'order_id',
    ];
}
