<section class="cart col-12 col-12 col-md-6 col-lg-8 col-xl-9" id="cart">
    <div>
        <div class="d-flex justify-content-between main-header">
            <div class="text-uppercase cart-title">giỏ hàng</div>
        </div>
        <div class="line"></div>
        @if(session('alert'))
        <div>{!! session('alert') !!}</div>
        @endif
        @if ($cartItemsCount)
        <div id="alert"></div>
        <div class="check-table table-responsive">
            <table class="table  table-bordered text-center table-md" >
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên sản phẩm </th>
                        <th scope="col">Số lượng</th>
                        <th scope="col" width="10%">Đơn giá </th>
                        <th scope="col">Thành tiền</th>
                        <th scope="col">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carts->cartItems as $key => $cartItem)
                    <tr>
                        <th scope="row">{!! $key + 1 !!}</th>
                        <td>
                            <div class="row ml-0 mr-0">
                                <span class="col-12 col-md-2 col-lg-3 col-xl-2"><img src="{!! $cartItem->product->thumbnail !!}" alt=""></span>
                                <div class="col-12 col-md-10 col-lg-9 col-xl-10 mt-2 ">{!! $cartItem->product->name !!}</div>
                            </div>
                        </td>
                        <td class="table-form-input">
                            <input id="cart-item-quantity" class="cart-quantity" data-id="{!! $cartItem->id !!}" name="quantity" value="{!! $cartItem->quantity !!}" type="number" min="1">
                        </td>
                        <td>{!! number_format($cartItem->price) !!} đ</td>
                        <td><span id="amount-{!! $cartItem->id !!}" class="amount" data-id={!! $cartItem->id !!}>{!! number_format($cartItem->amount) !!}</span> đ</td>
                        <td>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmModal-{!! $cartItem->id !!}">Xóa</button>
                        </td>
                    </tr>
                    <div id="confirmModal-{!! $cartItem->id !!}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content mt-5">
                                <div class="modal-body">
                                    <h4 class="text-center mt-3">Xóa khỏi giỏ hàng ?</h4>
                                    <div class="d-flex justify-content-center mt-4  ">
                                        <a href="{{ route('cart-items.delete', ['id' => $cartItem->id]) }}"  class="btn btn-danger text-white" >Xóa</a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <tr>
                        <td class="text-right" colspan="4"><b class="text-uppercase"> Tổng hóa đơn:</b></td>
                        <td colspan="3" class="total-price"><span id="total">{!! number_format($carts->total) !!}</span> đ</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="btn-next-comeback d-flex justify-content-end mb-2 mb-lg-0">
            <a href="/" class="btn-next mr-2 mr-md-4">TIẾP TỤC MUA HÀNG</a>
            <a href="/order-info" class="btn-order">Đặt hàng</a>
        </div>
        @else
        <div class="alert alert-danger">
            <p>Không có sản phẩm nào trong giỏ hàng</p>
        </div>
        @endif
    </div>
</section>
