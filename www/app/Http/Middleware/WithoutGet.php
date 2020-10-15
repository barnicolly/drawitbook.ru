<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WithoutGet
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = $request->input();
        if ($data) {
            $redirectUrl = $request->url();
            return redirect($redirectUrl, 301);
        }
        return $next($request);
    }
}
