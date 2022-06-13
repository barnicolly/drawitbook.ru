<?php

namespace App\Ship\Middlewares;

use App\Ship\Parents\Contracts\MiddlewareContract;
use Closure;
use Illuminate\Http\Request;

class WithoutGet implements MiddlewareContract
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        $data = $request->input();
        $redirectUrl = urldecode($request->getPathInfo());
        $test = urldecode($request->getRequestUri());
        if ($data || $redirectUrl !== $test) {
            return redirect($redirectUrl, 301);
        }
        return $next($request);
    }
}
