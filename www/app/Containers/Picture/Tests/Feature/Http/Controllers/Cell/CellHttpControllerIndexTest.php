<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Cell;

use App\Containers\Picture\Http\Controllers\Cell\CellHttpController;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Services\Route\RouteService;
use Tests\TestCase;

/**
 * @see CellHttpController::index()
 */
class CellHttpControllerIndexTest extends TestCase
{

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testCellIndexResponseCode200(string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteArtsCell());
        $response->assertStatus(200);
    }

    public function testHasEnTranslatedTitle(): void
    {
        $this->app->setLocale(LangEnum::EN);
        $response = $this->get((new RouteService())->getRouteArtsCell());
        $response->assertSee('<title>Pixel arts | Drawitbook.com</title>', false);
    }

    public function testHasEnTranslatedDescription(): void
    {
        $this->app->setLocale(LangEnum::EN);
        $response = $this->get((new RouteService())->getRouteArtsCell());
        $response->assertSee('<meta name="description" content="Pixel arts. Black/white and colored schemes of pixel arts from light and simple to complex.">', false);
    }

    public function testHasRuTranslatedTitle(): void
    {
        $this->app->setLocale(LangEnum::RU);
        $response = $this->get((new RouteService())->getRouteArtsCell());
        $response->assertSee('<title>Рисунки по клеточкам | Drawitbook.com</title>', false);
    }

    public function testHasRuTranslatedDescription(): void
    {
        $this->app->setLocale(LangEnum::RU);
        $response = $this->get((new RouteService())->getRouteArtsCell());
        $response->assertSee('<meta name="description" content="Рисунки по клеточкам. Схемы чёрно-белых и цветных рисунков от легких и простых до сложных.">', false);
    }

}
