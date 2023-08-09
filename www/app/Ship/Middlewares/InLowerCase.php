<?php

declare(strict_types=1);

namespace App\Ship\Middlewares;

use App\Ship\Parents\Contracts\MiddlewareContract;
use Closure;
use Illuminate\Http\Request;

final class InLowerCase implements MiddlewareContract
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $url = urldecode($request->getPathInfo());
        $assert = trim(mb_strtolower(urldecode($request->getPathInfo())));
        if ($assert !== $url) {
            return redirect($assert, 301);
        }
        return $next($request);
    }
}
