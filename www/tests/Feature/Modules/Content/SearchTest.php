<?php

namespace Tests\Feature\Modules\Content;

use App\Services\Route\RouteService;
use Tests\TestCase;

class SearchTest extends TestCase
{

    public function testSearchPageResponseCode200(): void
    {
        $response = $this->get((new RouteService())->getRouteSearch());
        $response->assertStatus(200);
    }

    public function testPageHasRobotsNoindex(): void
    {
        $response = $this->get((new RouteService())->getRouteSearch());
        $response->assertSee('<meta name="robots" content="noindex, follow">', false);
    }
}
