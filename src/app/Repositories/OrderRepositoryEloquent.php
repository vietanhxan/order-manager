<?php

namespace VCComponent\Laravel\Order\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use VCComponent\Laravel\Order\Entities\Order;
use VCComponent\Laravel\Order\Repositories\OrderRepository;
use VCComponent\Laravel\Vicoders\Core\Exceptions\NotFoundException;

/**
 * Class AccountantRepositoryEloquent.
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    public function getEntity()
    {
        return $this->model;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findById($id)
    {
        $order = $this->model->find($id);
        if (!$order) {
            throw new NotFoundException('Order');
        }
        return $order;
    }

    public function updateStatus($request, $id)
    {
        $updateStatus            = $this->find($id);
        $updateStatus->status_id = $request->input('status');
        $updateStatus->save();
    }

    public function paymentStatus($request, $id)
    {
        $paymentStatus                 = $this->find($id);
        $paymentStatus->payment_status = $request->input('payment_status');
        $paymentStatus->save();
    }
}
