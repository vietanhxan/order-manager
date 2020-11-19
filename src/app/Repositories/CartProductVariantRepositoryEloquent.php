<?php

namespace VCComponent\Laravel\Order\Repositories;

use VCComponent\Laravel\Order\Entities\CartProductVariant;
use VCComponent\Laravel\Order\Repositories\CartProductVariantRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CartPoductVariantRepositoryEloquent.
 *
 * @package namespace VCComponent\Laravel\Order\Repositories;
 */
class CartProductVariantRepositoryEloquent extends BaseRepository implements CartProductVariantRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CartProductVariant::class;
    }

    public function getEntity()
    {
        return $this->model;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
