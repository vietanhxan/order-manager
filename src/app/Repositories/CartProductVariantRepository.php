<?php

namespace VCComponent\Laravel\Order\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CartProductVariantRepository.
 *
 * @package namespace App\Repositories;
 */
interface CartProductVariantRepository extends RepositoryInterface
{
    public function getEntity();
}
