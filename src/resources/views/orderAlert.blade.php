<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="/css/app.css" />
        <script src="/js/app.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="d-flex justify-content-center mt-5">
                <div >
                    @if(session('alert') !== null)
                    <div class="d-flex justify-content-center">
                        <img class="img-fluid img-modal" src="/images/cart/error.png" width="40%" alt="">
                    </div>
                    <div class="text-uppercase d-flex justify-content-center mt-3 mb-4">
                        <div class="text-danger mt-5"> <b>{!! session('alert') !!}</b></div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="/" class="btn btn-secondary">Trở lại trang chủ</a>
                    </div>
                    @elseif(session('payment_response')->status_code == true)
                    <div class="d-flex justify-content-center">
                        <img class="img-fluid img-modal" src="/images/cart/tick.png" width="40%" alt="">
                    </div>
                    <div class="text-uppercase d-flex justify-content-center mt-3 mb-4">
                        <b>Đặt hàng thành công !</b>
                    </div>
                    <div class="d-flex justify-content-center">
                        <p>Chúng tôi sẽ liên hệ ngay với quý khách ngay để xác nhận đơn hàng !</p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="{{ url('/') }}" class="btn btn-primary">Về trang chủ</a>
                    </div>
                    @else
                    <div class="d-flex justify-content-center">
                        <img class="img-fluid img-modal" src="/images/cart/error.png" width="40%" alt="">
                    </div>
                    <div class="text-uppercase d-flex justify-content-center mt-3 mb-4">
                        <div class="text-danger mt-5"> <b>Lỗi xử lí serve ! Vui lòng thử lại hoặc báo với quản trị viên !</b></div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="/" class="btn btn-secondary">Trở lại trang chủ</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
