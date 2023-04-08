<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Cell;

use App\Containers\Picture\Http\Controllers\Cell\CellHttpController;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see CellHttpController::index()
 */
class CellHttpControllerIndexTest extends TestCase
{

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testCellIndexResponseCode200(string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get($this->routeService->getRouteArtsCell());
        $response->assertOk();
    }

    public function testHasEnTranslatedTitleAndDescription(): void
    {
        $this->app->setLocale(LangEnum::EN);
        $response = $this->get($this->routeService->getRouteArtsCell());
        $response->assertSee('<title>Pixel arts | Drawitbook.com</title>', false)
            ->assertSee('<meta name="description" content="Pixel arts. Black/white and colored schemes of pixel arts from light and simple to complex.">', false);
    }

    public function testHasRuTranslatedTitleAndDescription(): void
    {
        $this->app->setLocale(LangEnum::RU);
        $response = $this->get($this->routeService->getRouteArtsCell());
        $response->assertSee('<title>Рисунки по клеточкам | Drawitbook.com</title>', false)
            ->assertSee('<meta name="description" content="Рисунки по клеточкам. Схемы чёрно-белых и цветных рисунков от легких и простых до сложных.">', false);
    }

}
