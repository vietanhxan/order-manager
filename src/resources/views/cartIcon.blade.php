<div class="col-4 col-sm-2 col-md-2  d-flex justify-content-center">
    <div class="cart my-2 my-lg-0 mb-lg-0 fa-2x">
        @if ($cartItemsCount)
        <span class="cart__badge">{!! $cartItemsCount !!}</span>
        @endif
        <a href="{{ url('cart') }}"><img src="/images/cart/cart.png" alt=""></a>
    </div>
</div>
