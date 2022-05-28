<?php

namespace App\Containers\Search\Tests\Feature\Http\Controllers;

use App\Services\Route\RouteService;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testSearchPageResponseCode200(string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteSearch());
        $response->assertStatus(200);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testPageHasRobotsNoindex(string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteSearch());
        $response->assertSee('<meta name="robots" content="noindex, follow">', false);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testHasAlternate(string $locale)
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteSearch());
        $response->assertSee('<link rel="alternate" href="', false);
    }
}
