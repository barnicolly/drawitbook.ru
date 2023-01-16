<?php

namespace App\Ship\Middlewares;

use App\Ship\Parents\Contracts\MiddlewareContract;
use Closure;
use Illuminate\Http\Request;

class OnlyAjax implements MiddlewareContract
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        if (!$request->ajax())
            return response('Forbidden.', 403);

        return $next($request);
    }
}
