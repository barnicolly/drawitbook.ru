<?php

namespace App\Ship\Parents\Contracts;

use Closure;
use Illuminate\Http\Request;

interface MiddlewareContract
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed;
}
