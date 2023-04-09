<?php
namespace App\Containers\Authorization\Http\Middleware;
use Illuminate\Http\Request;
use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() === null) {
            return response("Unauthorized", 401);
        }
        $actions = $request->route()->getAction();
        $roles = $actions['roles'] ?? null;
        if ($request->user()->hasAnyRole($roles) || !$roles) {
            return $next($request);
        }
        return response("Insufficient permissions", 403);
    }
}
