<?php

namespace VCComponent\Laravel\Order\Http\Controllers\Api\Fontend;

use Complex\Exception;
use Illuminate\Http\Request;
use VCComponent\Laravel\Order\Entities\OrderItem;
use VCComponent\Laravel\Order\Repositories\OrderRepository;
use VCComponent\Laravel\Order\Transformers\OrderItemsTransformer;
use VCComponent\Laravel\Order\Transformers\OrderTransformer;
use VCComponent\Laravel\Order\Validators\OrderValidator;
use VCComponent\Laravel\Product\Entities\Product;
use VCComponent\Laravel\Vicoders\Core\Controllers\ApiController;

class OrderController extends ApiController
{
    protected $repository;
    protected $validator;

    public function __construct(OrderRepository $repository, OrderValidator $validator)
    {
        $this->repository  = $repository;
        $this->entity      = $repository->getEntity();
        $this->validator   = $validator;
        $this->transformer = OrderTransformer::class;
    }

    public function index(Request $request, $id)
    {
        $query = $this->entity;

        $query = $this->applyConstraintsFromRequest($query, $request);
        $query = $this->applySearchFromRequest($query, [], $request);
        $query = $this->applyOrderByFromRequest($query, $request);

        $per_page = $request->has('per_page') ? (int) $request->get('per_page') : 15;

        $order = $query->where('user_id', $id)->paginate($per_page);

        return $this->response->paginator($order, new $this->transformer);
    }

    public function show(Request $request, $id)
    {
        $query = $this->entity;

        $query = $this->applyConstraintsFromRequest($query, $request);
        $query = $this->applySearchFromRequest($query, [], $request);
        $query = $this->applyOrderByFromRequest($query, $request);

        $per_page = $request->has('per_page') ? (int) $request->get('per_page') : 15;

        $order = $query->where('user_id', $id)->paginate($per_page);

        return $this->response->paginator($order, new $this->transformer);
    }

    public function store(Request $request)
    {
        $this->validator->isValid($request, 'RULE_ADMIN_CREATE');

        $data = $request->all();
        if ($request->has('order_items')) {
            unset($data['order_items']);
        }

        $order = $this->repository->firstOrCreate($data);

        if ($request->has('order_items')) {
            $data             = $request->get('order_items');
            $data['order_id'] = $order->id;

            $product_ids = collect($request->get('order_items'))->pluck('product_id');
            $products    = Product::whereIn('id', $product_ids)->get();

            if (!$products->count()) {
                throw new \Exception("Sản phẩm không tồn tại", 1);
            }

            foreach ($request->get('order_items') as $value) {
                $product = $products->first(function ($item, $key) use ($value) {
                    return $item->id == $value['product_id'];
                });
                if ($product->quantity < $value['quantity']) {
                    throw new \Exception("Sản phẩm {$product->name} không đủ số lượng", 1);
                }
            }

            $total = $order->total;
            foreach ($request->get('order_items') as $value) {
                $product = $products->first(function ($item, $key) use ($value) {
                    return $item->id == $value['product_id'];
                });
                $order_item             = new OrderItem;
                $order_item->order_id   = $order->id;
                $order_item->product_id = $product->id;
                $order_item->price      = $product->price;
                $order_item->quantity   = $value['quantity'];
                $order_item->save();

                $product->quantity -= (int) $value['quantity'];
                $product->sold_quantity += (int) $value['quantity'];
                $product->save();

                $calcualator = $product->price * $value['quantity'];
                $total += (int) $calcualator;
            }
            $order->total = $total;
            $order->save();
        }

        return $this->response->item($order, new $this->transformer);
    }
}
