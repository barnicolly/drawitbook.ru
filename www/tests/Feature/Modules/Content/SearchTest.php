<?php

namespace Tests\Feature\Modules\Content;

use App\Services\Route\RouteService;
use Tests\TestCase;

class SearchTest extends TestCase
{

    /**
     * @dataProvider \Tests\Providers\CommonProvider::providerLanguages
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
     * @dataProvider \Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testPageHasRobotsNoindex(string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteSearch());
        $response->assertSee('<meta name="robots" content="noindex, follow">', false);
    }
}
