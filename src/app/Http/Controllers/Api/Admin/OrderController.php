<?php

namespace VCComponent\Laravel\Order\Http\Controllers\Api\Admin;

use Complex\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use VCComponent\Laravel\Order\Entities\OrderItem;
use VCComponent\Laravel\Order\Facades\Order;
use VCComponent\Laravel\Order\Mail\MailNotify;
use VCComponent\Laravel\Order\Repositories\OrderRepository;
use VCComponent\Laravel\Order\Transformers\OrderTransformer;
use VCComponent\Laravel\Order\Validators\OrderValidator;
use VCComponent\Laravel\Product\Entities\Product;
use VCComponent\Laravel\Vicoders\Core\Controllers\ApiController;

class OrderController extends ApiController
{
    protected $repositoryOrder;
    protected $validatorOrder;

    public function __construct(OrderRepository $repositoryOrder, OrderValidator $validatorOrder)
    {
        $this->repositoryOrder = $repositoryOrder;
        $this->entity          = $repositoryOrder->getEntity();
        $this->validatorOrder  = $validatorOrder;
        $this->transformer     = OrderTransformer::class;

        if (config('order.auth_middleware.admin.middleware') !== '') {
            $user = $this->getAuthenticatedUser();
            if (!$this->entity->ableToUse($user)) {
                throw new PermissionDeniedException();
            }
        }
    }

    public function index(Request $request)
    {
        $query = $this->entity;

        $query = $this->applyConstraintsFromRequest($query, $request);
        $query = $this->applySearchFromRequest($query, ['status'], $request);
        $query = $this->applyOrderByFromRequest($query, $request);

        if ($request->has('status')) {

            $request->validate([
                'status' => 'required|regex:/^(\d+\,?)*$/',
            ]);

            $status = explode(',', $request->get('status'));
            $query  = $query->whereIn('status_id', $status);
        }

        if ($request->has('payment_status')) {

            $request->validate([
                'payment_status' => 'required|regex:/^(\d+\,?)*$/',
            ]);

            $payment_status = explode(',', $request->get('payment_status'));
            $query          = $query->whereIn('payment_status', $payment_status);
        }

        $per_page = $request->has('per_page') ? (int) $request->get('per_page') : 15;
        $order    = $query->paginate($per_page);

        if ($request->has('includes')) {
            $transformer = new $this->transformer(explode(',', $request->get('includes')));
        } else {
            $transformer = new $this->transformer;
        }

        return $this->response->paginator($order, $transformer);
    }

    public function show($id, Request $request)
    {
        $order = $this->repositoryOrder->findById($id);

        if ($request->has('includes')) {
            $transformer = new $this->transformer(explode(',', $request->get('includes')));
        } else {
            $transformer = new $this->transformer;
        }

        return $this->response->item($order, $transformer);
    }

    public function store(Request $request)
    {
        $this->validatorOrder->isValid($request, 'RULE_ADMIN_CREATE');

        $data = $request->all();
        if ($request->has('order_items')) {
            unset($data['order_items']);
        }

        $order = $this->repositoryOrder->firstOrCreate($data);

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

    public function update(Request $request, $id)
    {
        $this->validatorOrder->isValid($request, 'RULE_ADMIN_UPDATE');

        $this->repositoryOrder->findById($id);

        $data  = $request->all();
        $order = $this->repositoryOrder->update($data, $id);

        return $this->response->item($order, new $this->transformer);
    }

    public function destroy($id)
    {
        $order = $this->repositoryOrder->findById($id);
        if ($order->orderItems->count()) {
            throw new \Exception("Đang có sản phẩm trong giỏ hàng có id = {$order->id}", 1);
        } else {
            $order->delete();
        }

        return $this->success();
    }

    public function updateStatus(Request $request, $id)
    {
        $this->validatorOrder->isValid($request, 'UPDATE_STATUS_ITEM');

        $this->repositoryOrder->findById($id);

        $this->repositoryOrder->updateStatus($request, $id);

        return $this->success();
    }

    public function paymentStatus(Request $request, $id)
    {
        $this->validatorOrder->isValid($request, 'UPDATE_PAYMENT_STATUS');

        $this->repositoryOrder->findById($id);

        $this->repositoryOrder->paymentStatus($request, $id);
        return $this->success();
    }

    public function sendMailOrderSuccess($id)
    {
        $this->repositoryOrder->findById($id);

        $order = Order::where('id', $id)->with('orderItems.product', 'paymentMethod')->first();

        $email = $order->email;

        if (!$email) {
            return response()->json('Đơn hàng này không có địa chỉ email !');
        }

        Mail::to($email)->send(new MailNotify($email, $order));

        if (Mail::failures()) {
            return response()->json('Đã sảy ra lỗi ! Vui lòng kiểm tra lại địa chỉ email !');
        }

        return response()->json('Mail đã được gửi tới ' . $email . ' !');

    }
}
