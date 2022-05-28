<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Cell;

use App\Enums\Lang;
use App\Services\Route\RouteService;
use Tests\TestCase;

class CellTest extends TestCase
{

    /**
     * @dataProvider \Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testCellIndexResponseCode200(string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteArtsCell());
        $response->assertStatus(200);
    }

    public function testHasEnTranslatedTitle()
    {
        $this->app->setLocale(Lang::EN);
        $response = $this->get((new RouteService())->getRouteArtsCell());
        $response->assertSee('<title>Pixel arts | Drawitbook.com</title>', false);
    }

    public function testHasEnTranslatedDescription()
    {
        $this->app->setLocale(Lang::EN);
        $response = $this->get((new RouteService())->getRouteArtsCell());
        $response->assertSee('<meta name="description" content="Pixel arts. Black/white and colored schemes of pixel arts from light and simple to complex.">', false);
    }

    public function testHasRuTranslatedTitle()
    {
        $this->app->setLocale(Lang::RU);
        $response = $this->get((new RouteService())->getRouteArtsCell());
        $response->assertSee('<title>Рисунки по клеточкам | Drawitbook.com</title>', false);
    }

    public function testHasRuTranslatedDescription()
    {
        $this->app->setLocale(Lang::RU);
        $response = $this->get((new RouteService())->getRouteArtsCell());
        $response->assertSee('<meta name="description" content="Рисунки по клеточкам. Схемы чёрно-белых и цветных рисунков от легких и простых до сложных.">', false);
    }

}
