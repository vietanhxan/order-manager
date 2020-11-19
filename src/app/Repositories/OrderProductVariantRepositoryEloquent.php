<?php

namespace VCComponent\Laravel\Order\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use VCComponent\Laravel\Order\Entities\OrderMail;
use VCComponent\Laravel\Order\Entities\OrderProductVariant;
use VCComponent\Laravel\Order\Repositories\OrderProductVariantRepository;
use VCComponent\Laravel\Vicoders\Core\Exceptions\NotFoundException;

/**
 * Class AccountantRepositoryEloquent.
 */
class OrderProductVariantRepositoryEloquent extends BaseRepository implements OrderProductVariantRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderProductVariant::class;
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
