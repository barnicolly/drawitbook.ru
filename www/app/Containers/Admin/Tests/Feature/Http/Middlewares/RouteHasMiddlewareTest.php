<?php

namespace App\Containers\Admin\Tests\Feature\Http\Middlewares;

use App\Ship\Parents\Tests\TestCase;

class RouteHasMiddlewareTest extends TestCase
{

    public function testRouteHasMiddlewares(): void
    {
        $routes = [];
        $routes[] = 'admin.posting.vk.on';
        $routes[] = 'admin.posting.vk.on';
        $routes[] = 'admin.posting.vk.album.attach';
        $routes[] = 'admin.posting.vk.album.detach';
        $routes[] = 'admin.picture.settings';
        foreach ($routes as $routeName) {
            $this->assertRouteUsesMiddleware($routeName, ['roles']);
        }
    }
}
