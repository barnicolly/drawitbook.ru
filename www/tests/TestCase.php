<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Make ajax POST request
     * @param $uri
     * @param array $data
     * @return TestResponse
     */
    protected function ajaxPost($uri, array $data = []): TestResponse
    {
        return $this->post($uri, $data, ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
    }

    /**
     * Make ajax GET request
     */
    protected function ajaxGet($uri): TestResponse
    {
        return $this->get($uri, ['HTTP_X-Requested-With' => 'XMLHttpRequest', 'Accept' => 'application/json']);
    }

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
