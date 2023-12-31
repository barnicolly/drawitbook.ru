<?php

declare(strict_types=1);

namespace App\Ship\Parents\Contracts;

use Closure;
use Illuminate\Http\Request;

interface MiddlewareContract
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed;
}
