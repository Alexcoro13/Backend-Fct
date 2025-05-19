<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddSanctumTokenMiddleWare
{
    public function handle(Request $request, Closure $next)
    {
        if ($token = $request->cookie('laravel_token')) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        return $next($request);
    }
}
