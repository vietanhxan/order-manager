<?php

namespace VCComponent\Laravel\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use VCComponent\Laravel\Product\Entities\Variant;

/**
 * Class CartProductVariant.
 *
 * @package namespace App\Entities;
 */
class CartProductVariant extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['cart_item_id', 'variant_type', 'variant_id'];

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }
}
