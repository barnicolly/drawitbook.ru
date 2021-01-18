<?php

namespace Tests\Feature\Modules\Content;

use App\Services\Route\RouteService;
use Tests\TestCase;

class ContentTest extends TestCase
{

    public function testHomePageResponseCode200(): void
    {
        $response = $this->get((new RouteService())->getRouteHome());
        $response->assertStatus(200);
    }
}
