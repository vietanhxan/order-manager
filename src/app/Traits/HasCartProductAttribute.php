<?php

namespace VCComponent\Laravel\Order\Traits;

use VCComponent\Laravel\Order\Entities\CartProductAttribute;

trait HasCartProductAttributes
{
    public function itemAttributes()
    {
        return $this->hasMany(CartProductAttribute::class)->with('attributeValue.attribute');
    }
}
