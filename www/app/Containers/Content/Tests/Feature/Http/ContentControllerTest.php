<?php

namespace App\Containers\Content\Tests\Feature\Http;

use App\Containers\Content\Http\Controllers\ContentHttpController;
use App\Ship\Services\Route\RouteService;
use Tests\TestCase;

/**
 * @see ContentHttpController::index()
 */
class ContentControllerTest extends TestCase
{

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testHomePageResponseCode200(string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteHome());
        $response->assertStatus(200);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testHasAlternate(string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteHome());
        $response->assertSee('<link rel="alternate" href="', false);
    }
}
