<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['prefix' => 'admin'], function ($api) {
        $api->resource("/orders", "VCComponent\Laravel\Order\Http\Controllers\Api\Admin\OrderController");
        $api->put("/orders/{id}/payment-status/", "VCComponent\Laravel\Order\Http\Controllers\Api\Admin\OrderController@paymentStatus");
        $api->put("/orders/{id}/status", "VCComponent\Laravel\Order\Http\Controllers\Api\Admin\OrderController@updateStatus");
        $api->put("/order_item/{id}/product", "VCComponent\Laravel\Order\Http\Controllers\Api\Admin\OrderItemController@update");
        $api->delete("/order_item/{id}/product", "VCComponent\Laravel\Order\Http\Controllers\Api\Admin\OrderItemController@destroy");
        $api->get("/orders/{id}/sendMailOrder", "VCComponent\Laravel\Order\Http\Controllers\Api\Admin\OrderController@sendMailOrderSuccess");
    });
    $api->put("/cart_item/{id}/quantity","VCComponent\Laravel\Order\Http\Controllers\Api\Fontend\Cart\CartItemController@changeQuantity");
    $api->get('/users/{id}/orders', 'VCComponent\Laravel\Order\Http\Controllers\Api\Fontend\OrderController@index');
    $api->get('/orders/{id}', 'VCComponent\Laravel\Order\Http\Controllers\Api\Fontend\OrderController@show');
    $api->post('/orders', 'VCComponent\Laravel\Order\Http\Controllers\Api\Fontend\OrderController@store');
});
