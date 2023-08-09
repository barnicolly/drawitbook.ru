<?php

declare(strict_types=1);

namespace App\Containers\Picture\Tests\Feature\Http\Middlewares;

use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tests\TestCase;

final class RouteHasMiddlewareTest extends TestCase
{
    public function testRouteHasMiddlewares(): void
    {
        $routes = [];
        foreach (LangEnum::asArray() as $prefix) {
            $routes[] = $prefix . '_arts.cell';
            $routes[] = $prefix . '_arts.cell.tagged';
            $routes[] = $prefix . '_art';
        }
        foreach ($routes as $routeName) {
            $this->assertRouteUsesMiddleware($routeName, ['lower_case', 'no_get']);
        }
    }
}
