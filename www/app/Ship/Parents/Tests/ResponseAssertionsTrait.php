<?php

namespace App\Ship\Parents\Tests;

use Illuminate\Routing\Router;
use PHPUnit\Framework\Assert;

trait ResponseAssertionsTrait
{
    public function assertRouteUsesMiddleware(string $routeName, array $middlewares, bool $exact = false): void
    {
        $router = resolve(Router::class);

        $route = $router->getRoutes()->getByName($routeName);
        $usedMiddlewares = $route->gatherMiddleware();

        Assert::assertNotNull($route, "Unable to find route for name `{$routeName}`");

        if ($exact) {
            $unusedMiddlewares = array_diff($middlewares, $usedMiddlewares);
            $extraMiddlewares = array_diff($usedMiddlewares, $middlewares);

            $messages = [];

            if ($extraMiddlewares) {
                $messages[] = 'uses unexpected `' . implode(', ', $extraMiddlewares) . '` middlware(s)';
            }

            if ($unusedMiddlewares) {
                $messages[] = "doesn't use expected `" . implode(', ', $unusedMiddlewares) . '` middlware(s)';
            }

            $messages = implode(' and ', $messages);

            Assert::assertSame(
                count($unusedMiddlewares) + count($extraMiddlewares),
                0,
                "Route `{$routeName}` " . $messages,
            );
        } else {
            $unusedMiddlewares = array_diff($middlewares, $usedMiddlewares);

            Assert::assertEmpty(
                $unusedMiddlewares,
                "Route `{$routeName}` does not use expected `" . implode(
                    ', ',
                    $unusedMiddlewares,
                ) . '` middleware(s)',
            );
        }
    }
}
