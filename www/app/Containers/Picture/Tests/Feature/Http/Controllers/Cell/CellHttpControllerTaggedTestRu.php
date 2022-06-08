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
class CellHttpControllerTaggedTestRu extends TestCase
{
    use CreateTagTrait, CreatePictureWithRelationsTrait;

    public function setUp(): void
    {
        parent::setUp();
        $this->app->setLocale(LangEnum::RU);
    }

    public function testCellCategoryOk(): void
    {
        $tag = $this->createTag();
        for ($index = 1; $index < 30; $index++) {
            [$picture] = $this->createPictureWithFile();
            $this->createPictureTag($picture, $tag);
        }

        $response = $this->get($this->routeService->getRouteArtsCellTagged($tag->seo));

        $response->assertOk();
    }

    public function testHasRedirectsIfUndefinedLang(): void
    {
        $tag = $this->createTag();

        $url = $this->routeService->getRouteArtsCellTagged($tag->slug_en);
        $response = $this->withHeader('accept-language', 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7')
            ->get($url);

        $expectedTag = $tag->seo;
        $assetRedirect = $this->routeService->getRouteArtsCellTagged($expectedTag);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }

    public function testHasRedirects(): void
    {
        $tag = $this->createTag();

        $url = $this->routeService->getRouteArtsCellTagged($tag->slug_en);
        $response = $this->get($url);

        $expectedTag = $tag->seo;
        $assetRedirect = $this->routeService->getRouteArtsCellTagged($expectedTag);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }

    public function testHasNotAlternate(): void
    {
        $tag = $this->createTag([SprTagsColumnsEnum::SLUG_EN => null, SprTagsColumnsEnum::NAME_EN => null]);
        [$picture] = $this->createPictureWithFile();
        $this->createPictureTag($picture, $tag);

        $response = $this->get($this->routeService->getRouteArtsCellTagged($tag->seo));

        $response->assertDontSee('<link rel="alternate" href="', false);
    }

    public function testHasCorrectSeo(): void
    {
        $tag = $this->createTag();
        $countPictures = 24;
        for ($index = 1; $index <= $countPictures; $index++) {
            [$picture] = $this->createPictureWithFile();
            $this->createPictureTag($picture, $tag);
        }

        $url = $this->routeService->getRouteArtsCellTagged($tag->seo);
        $response = $this->get($url);

        $response->assertOk();
        $response->assertSee("<title>Рисунки по клеточкам «{$tag->name}» ☆ {$countPictures} рисунка</title>", false);
        $response->assertSee(
            "<meta name=\"description\" content=\"Рисунки по клеточкам ✎ {$tag->name} ➣ {$countPictures} рисунка ➣ Схемы чёрно-белых и цветных рисунков от легких и простых до сложных.\">",
            false
        );
        $alternativeLang = LangEnum::EN;
        $alternativeUrl = $this->routeService->getRouteArtsCellTagged($tag->slug_en, true, $alternativeLang);
        $response->assertSee(
            "<link rel=\"alternate\" href=\"$alternativeUrl\" hreflang=\"{$alternativeLang}\">",
            false
        );
    }
}
