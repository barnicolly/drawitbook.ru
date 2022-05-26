<?php

namespace App\Containers\Content\Tests\Feature\Http;

use App\Services\Route\RouteService;
use Tests\TestCase;

class ContentControllerTest extends TestCase
{

    /**
     * @dataProvider \Tests\Providers\CommonProvider::providerLanguages
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
     * @dataProvider \Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testHasAlternate(string $locale)
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteHome());
        $response->assertSee('<link rel="alternate" href="', false);
    }
}
