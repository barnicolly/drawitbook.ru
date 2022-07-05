<?php

namespace App\Containers\Search\Tests\Feature\Http\Controllers;

use App\Containers\Search\Http\Controllers\SearchController;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see SearchController::index()
 */
class ShowSearchIndexPageTest extends TestCase
{

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testSearchPageResponseCode200(string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get($this->routeService->getRouteSearch());
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
        $response = $this->get($this->routeService->getRouteSearch());
        $response->assertSee('<meta name="robots" content="noindex, follow">', false);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testHasAlternate(string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get($this->routeService->getRouteSearch());
        $response->assertSee('<link rel="alternate" href="', false);
    }
}
