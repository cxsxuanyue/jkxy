<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class HomeLogin
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
        // 判断用户是否登录 没有则返回到登录页面
        if(!Session::get('user')){

            return redirect('/');
        }

        return $next($request);
    }
}
