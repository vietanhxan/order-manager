<?php

namespace VCComponent\Laravel\Order\Http\Middleware;

use Closure;
use VCComponent\Laravel\Order\Actions\Cart\CreateCartAction;

class CheckCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cart = null;

        if ($request->hasCookie('cart')) {
            $cart = getCart();
        }

        if ($cart) {
            return $next($request);
        }

        $cart     = app(CreateCartAction::class)->execute();

        $response = $next($request);
        return $response->withCookie(cookie()->forever('cart', $cart->getKey()));
    }
}
