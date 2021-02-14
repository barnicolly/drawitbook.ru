<?php

namespace Tests\Feature\Modules\Content;

use App\Services\Route\RouteService;
use Tests\TestCase;

class ContentTest extends TestCase
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
}
