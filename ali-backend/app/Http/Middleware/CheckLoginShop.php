<?php

namespace App\Http\Middleware;

use Closure;

class CheckLoginShop
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
        if(auth('web_shop_users')->check()) return redirect()->route('shop.home');
        return $next($request);
    }
}
