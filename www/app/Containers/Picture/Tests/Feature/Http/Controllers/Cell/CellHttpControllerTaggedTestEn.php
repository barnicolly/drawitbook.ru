<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Cell;

use App\Containers\Picture\Http\Controllers\Cell\CellHttpController;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Tag\Tests\Traits\CreateTagTrait;
use App\Containers\Translation\Enums\LangEnum;
use Symfony\Component\HttpFoundation\Response;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see CellHttpController::tagged()
 */
class CellHttpControllerTaggedTestEn extends TestCase
{

//    todo-misha объединить тесты разной локализации;
    use CreateTagTrait, CreatePictureWithRelationsTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->app->setLocale(LangEnum::EN);
    }

    public function testCellCategoryOk(): void
    {
        $tag = $this->createTag();
        for ($index = 1; $index < 30; $index++) {
            [$picture] = $this->createPictureWithFile();
            $this->createPictureTag($picture, $tag);
        }

        $response = $this->get($this->routeService->getRouteArtsCellTagged($tag->slug_en));

        $response->assertOk();
    }

    public function testCellCategoryNotFound(): void
    {
        $tag = $this->createTag();

        $response = $this->get($this->routeService->getRouteArtsCellTagged($tag->slug_en));

        $response->assertNotFound();
    }

    public function testHasRedirectsIfUndefinedLang(): void
    {
        $tag = $this->createTag();

        $url = '/pixel-arts/' . $tag->slug_en;
        $response = $this->withHeader('accept-language', 'en-us,en;q=0.5')
            ->get($url);

        $expectedTag = $tag->slug_en;
        $assetRedirect = $this->routeService->getRouteArtsCellTagged($expectedTag);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }

    public function testHasRedirects(): void
    {
        $tag = $this->createTag();

        $url = $this->routeService->getRouteArtsCellTagged($tag->seo);
        $response = $this->get($url);

        $expectedTag = $tag->slug_en;
        $assetRedirect = $this->routeService->getRouteArtsCellTagged($expectedTag);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }

    public function testNoRedirect(): void
    {
        $tag = $this->createTag([SprTagsColumnsEnum::SLUG_EN => null, SprTagsColumnsEnum::NAME_EN => null]);

        $response = $this->get($this->routeService->getRouteArtsCellTagged($tag->seo));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

//    todo-misha проверить что нет альтертивы если нет английского тега;

    public function testHasCorrectSeo(): void
    {
        $tag = $this->createTag();
        $countPictures = 12;
        for ($index = 1; $index <= $countPictures; $index++) {
            [$picture] = $this->createPictureWithFile();
            $this->createPictureTag($picture, $tag);
        }

        $url = $this->routeService->getRouteArtsCellTagged($tag->slug_en);
        $response = $this->get($url);

        $response->assertSee("<title>Pixel arts «{$tag->name_en}» ☆ $countPictures arts</title>", false);
        $response->assertSee(
            "<meta name=\"description\" content=\"Pixel arts ✎ {$tag->name_en} ➣ $countPictures arts ➣ Black/white and colored schemes of pixel arts from light and simple to complex.\">",
            false
        );
        $alternativeLang = LangEnum::RU;
        $alternativeUrl = $this->routeService->getRouteArtsCellTagged($tag->seo, true, $alternativeLang);
        $response->assertSee("<link rel=\"alternate\" href=\"$alternativeUrl\" hreflang=\"{$alternativeLang}\">", false);
    }
}
