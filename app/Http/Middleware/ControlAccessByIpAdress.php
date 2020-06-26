<?php

namespace App\Http\Middleware;

use Closure;

class ControlAccessByIpAdress
{

    public function handle($request, Closure $next)
    {

//        $valid_addresses = ['xxx.xxx.xxx.xxx', 'xxx.xxx.xxx.xxx'];
//
//        if (!in_array($request->ip(), $valid_addresses)) {
//            abort(403);
//        }

        return $next($request);
    }
}
