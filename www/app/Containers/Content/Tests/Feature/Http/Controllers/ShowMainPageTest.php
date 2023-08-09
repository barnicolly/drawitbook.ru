<?php

declare(strict_types=1);

namespace App\Containers\Content\Tests\Feature\Http\Controllers;

use App\Containers\Content\Http\Controllers\ContentHttpController;
use App\Ship\Parents\Tests\TestCase;
use App\Ship\Services\Route\RouteService;

/**
 * @see ContentHttpController::showMainPage()
 */
class ShowMainPageTest extends TestCase
{
    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testHomePageResponseCode200(string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteHome());
        $response->assertStatus(200);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testHasAlternate(string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteHome());
        $response->assertSee('<link rel="alternate" href="', false);
    }
}
