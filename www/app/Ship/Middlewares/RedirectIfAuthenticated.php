<?php

namespace App\Ship\Middlewares;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ?string $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('home');
        }

        return $next($request);
    }
}
