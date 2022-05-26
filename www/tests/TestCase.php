<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use PHPUnit\Framework\Assert;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function assertRouteUsesMiddleware(string $routeName, array $middlewares, bool $exact = false)
    {
        $router = resolve(\Illuminate\Routing\Router::class);

        $route = $router->getRoutes()->getByName($routeName);
        $usedMiddlewares = $route->gatherMiddleware();

        Assert::assertNotNull($route, "Unable to find route for name `$routeName`");

        if ($exact) {
            $unusedMiddlewares = array_diff($middlewares, $usedMiddlewares);
            $extraMiddlewares = array_diff($usedMiddlewares, $middlewares);

            $messages = [];

            if ($extraMiddlewares) {
                $messages[] = "uses unexpected `" . implode(', ', $extraMiddlewares) . "` middlware(s)";
            }

            if ($unusedMiddlewares) {
                $messages[] = "doesn't use expected `" . implode(', ', $unusedMiddlewares) . "` middlware(s)";
            }

            $messages = implode(" and ", $messages);

            Assert::assertTrue(
                count($unusedMiddlewares) + count($extraMiddlewares) === 0,
                "Route `$routeName` " . $messages
            );
        } else {
            $unusedMiddlewares = array_diff($middlewares, $usedMiddlewares);

            Assert::assertTrue(
                count($unusedMiddlewares) === 0,
                "Route `$routeName` does not use expected `" . implode(
                    ', ',
                    $unusedMiddlewares
                ) . "` middleware(s)"
            );
        }
    }
}
