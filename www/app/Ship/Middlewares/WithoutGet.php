<?php

namespace App\Ship\Middlewares;

class WithoutGet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
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
