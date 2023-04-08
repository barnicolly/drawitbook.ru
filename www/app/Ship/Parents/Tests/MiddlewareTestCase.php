<?php

namespace App\Ship\Parents\Tests;

use App\Ship\Parents\Contracts\MiddlewareContract;
use Illuminate\Http\Request;
use Route;
use Tests\TestCase as BaseTestCase;

abstract class MiddlewareTestCase extends BaseTestCase
{

    /**
     * @param string $url
     * @param array $middlewares
     * @return void
     */
    protected function createTestRouteWithMiddlewares(string $url, array $middlewares): void
    {
        Route::get($url, function (): string {
            return 'Ok';
        }
        )->middleware($middlewares);
        Route::post($url, function (): string {
            return 'Ok';
        }
        )->middleware($middlewares);
    }

    /**
     * @param MiddlewareContract $middleware
     * @param Request $request
     * @param bool $expectedCalledStatus
     * @return void
     */
    protected function assertCalledNextMiddleware(MiddlewareContract $middleware, Request $request, bool $expectedCalledStatus): void
    {
        $called = false;
        $next = function (Request $request) use (&$called): void {
            $called = true;
        };
        $middleware->handle($request, $next);
        $this->assertSame($expectedCalledStatus, $called);
    }
}
