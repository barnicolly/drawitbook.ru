<?php

declare(strict_types=1);

namespace App\Ship\Parents\Tests;

use App\Ship\Parents\Contracts\MiddlewareContract;
use Illuminate\Http\Request;
use Route;
use Tests\TestCase as BaseTestCase;

abstract class MiddlewareTestCase extends BaseTestCase
{
    protected function createTestRouteWithMiddlewares(string $url, array $middlewares): void
    {
        Route::get(
            $url,
            static fn (): string => 'Ok',
        )->middleware($middlewares);
        Route::post(
            $url,
            static fn (): string => 'Ok',
        )->middleware($middlewares);
    }

    protected function assertCalledNextMiddleware(
        MiddlewareContract $middleware,
        Request $request,
        bool $expectedCalledStatus,
    ): void {
        $called = false;
        $next = static function (Request $request) use (&$called): void {
            $called = true;
        };
        $middleware->handle($request, $next);
        $this->assertSame($expectedCalledStatus, $called);
    }
}
