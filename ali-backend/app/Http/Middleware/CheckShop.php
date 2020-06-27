<?php

namespace App\Http\Middleware;

use Closure;

class CheckShop
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
        if(auth('web_shop_users')->check()) {
            if(auth('admin')->check()) {
                auth('admin')->logout();
            }
            return $next($request);
        }
        return redirect()->route('shop.login');
    }
}
