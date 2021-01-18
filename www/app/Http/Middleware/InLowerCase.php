<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InLowerCase
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $url = urldecode($request->getPathInfo());
        $assert = trim(mb_strtolower(urldecode($request->getPathInfo())));
        if ($assert !== $url) {
            return redirect($assert, 301);
        }
        return $next($request);
    }
}
