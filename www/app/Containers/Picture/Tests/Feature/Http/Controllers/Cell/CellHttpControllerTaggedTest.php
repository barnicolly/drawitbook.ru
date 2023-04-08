<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Cell;

use App\Containers\Picture\Http\Controllers\Cell\CellHttpController;
use App\Containers\Picture\Models\PictureExtensionsModel;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Tag\Data\Dto\TagDto;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Tag\Tests\Traits\CreateTagTrait;
use App\Containers\Translation\Enums\LangEnum;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see CellHttpController::tagged()
 */
class CellHttpControllerTaggedTest extends TestCase
{

    use CreatePictureWithRelationsTrait;
    use CreateTagTrait;

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testCellCategoryOk(string $locale): void
    {
        $this->app->setLocale($locale);
        $tag = $this->createTag();
        $tagDto = TagDto::fromModel($tag, $locale);

        $pictures = new Collection();
        for ($index = 1; $index < 30; $index++) {
            [$picture] = $this->createPictureWithFile();
            $pictures->push($picture);
            $this->createPictureTag($picture, $tag);
        }

        $response = $this->get($this->routeService->getRouteArtsCellTagged($tagDto->seo_lang->current->slug));

        $response->assertOk();
        /** @var PictureExtensionsModel $firstExtension */
        $firstExtension = $pictures->first()?->extensions()->first();
        $path = asset(getArtsFolder() . $firstExtension->path);
        $response->assertSee(
            "<meta property=\"og:image\" content=\"$path\">",
            false
        );
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testCellCategoryNotFound(string $locale): void
    {
        $this->app->setLocale($locale);
        $tag = $this->createTag();
        $tagDto = TagDto::fromModel($tag, $locale);

        $response = $this->get($this->routeService->getRouteArtsCellTagged($tagDto->seo_lang->current->slug));

        $response->assertNotFound();
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testHasRedirects(string $locale): void
    {
        $this->app->setLocale($locale);
        $tag = $this->createTag();
        $tagDto = TagDto::fromModel($tag, $locale);

        $url = $this->routeService->getRouteArtsCellTagged($tagDto->seo_lang->alternative->slug);
        $response = $this->get($url);

        $expectedTag = $tagDto->seo_lang->current->slug;
        $assetRedirect = $this->routeService->getRouteArtsCellTagged($expectedTag);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testHasRedirectsIfUndefinedLang(string $locale): void
    {
        $acceptLanguageHeader = $locale === LangEnum::RU
            ? 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7'
            : 'en-us,en;q=0.5';
        $tag = $this->createTag();
        $tagDto = TagDto::fromModel($tag);

        $url = $this->routeService->getRouteArtsCellTagged($tagDto->seo_lang->alternative->slug);
        $response = $this->withHeader('accept-language', $acceptLanguageHeader)
            ->get($url);

        $expectedTag = $tagDto->seo_lang->current->slug;
        $assetRedirect = $this->routeService->getRouteArtsCellTagged($expectedTag);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testHasAlternativeLink(string $locale): void
    {
        $this->app->setLocale($locale);
        $tag = $this->createTag();
        [$picture] = $this->createPictureWithFile();
        $this->createPictureTag($picture, $tag);
        $tagDto = TagDto::fromModel($tag, $locale);

        $url = $this->routeService->getRouteArtsCellTagged($tagDto->seo_lang->current->slug);
        $response = $this->get($url);

        $alternativeLang = $tagDto->seo_lang->alternative->locale;
        $alternativeUrl = $this->routeService->getRouteArtsCellTagged(
            $tagDto->seo_lang->alternative->slug,
            true,
            $alternativeLang
        );
        $response->assertSee(
            "<link rel=\"alternate\" href=\"$alternativeUrl\" hreflang=\"{$alternativeLang}\">",
            false
        );
    }

    //  ------------------------  Specific tests for En locale ------------------------

    public function testEnNoRedirect(): void
    {
        $this->app->setLocale(LangEnum::EN);
        $tag = $this->createTag([SprTagsColumnsEnum::SLUG_EN => null, SprTagsColumnsEnum::NAME_EN => null]);

        $response = $this->get($this->routeService->getRouteArtsCellTagged($tag->seo));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testEnHasCorrectSeo(): void
    {
        $this->app->setLocale(LangEnum::EN);
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
    }

    //  ------------------------ Specific tests for Ru locale ------------------------

    public function testRuHasNotAlternate(): void
    {
        $this->app->setLocale(LangEnum::RU);
        $tag = $this->createTag([SprTagsColumnsEnum::SLUG_EN => null, SprTagsColumnsEnum::NAME_EN => null]);
        [$picture] = $this->createPictureWithFile();
        $this->createPictureTag($picture, $tag);

        $response = $this->get($this->routeService->getRouteArtsCellTagged($tag->seo));

        $response->assertDontSee('<link rel="alternate" href="', false);
    }

    public function testRuHasCorrectSeo(): void
    {
        $this->app->setLocale(LangEnum::RU);
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
    }
}
