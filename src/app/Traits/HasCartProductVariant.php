<?php

namespace VCComponent\Laravel\Order\Traits;

use VCComponent\Laravel\Order\Entities\CartProductVariant;

trait HasCartProductVariants
{
    public function itemAttributes()
    {
        return $this->hasMany(CartProductVariant::class)->with('attributeValue.attribute');
    }
}
