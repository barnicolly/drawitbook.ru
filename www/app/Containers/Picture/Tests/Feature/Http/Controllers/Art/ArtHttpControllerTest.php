<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Art;

use PHPUnit\Framework\MockObject\MockObject;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Tag\Tests\Traits\CreateTagTrait;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Services\File\FileService;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see \App\Containers\Picture\Http\Controllers\Art\ArtHttpController::index()
 */
class ArtHttpControllerTest extends TestCase
{
    use CreatePictureWithRelationsTrait;
    use CreateTagTrait;
    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testArtPageResponseCode200(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture, $file] = $this->createPictureWithFile();

        [$pictureForPopularTag] = $this->createPictureWithFile();
        $tagPopular = $this->createTag();
        $tagPopular->flag(FlagsEnum::TAG_IS_POPULAR);
        $this->createPictureTag($pictureForPopularTag, $tagPopular);

        $tagHidden = $this->createTag();
        $tagHidden->flag(FlagsEnum::TAG_HIDDEN);
        $this->createPictureTag($picture, $tagHidden);

        $tagNotHidden = $this->createTag();
        $this->createPictureTag($picture, $tagNotHidden);

        $mock = $this->createMock(FileService::class);
        $mock->method('formArtUrlPath')
            ->willReturn($file->path);
        $this->app->bind(FileService::class, function () use ($mock): MockObject&FileService {
            return $mock;
        });

        $response = $this->get($this->routeService->getRouteArt($picture->id));

        $response->assertOk();
        $response->assertSee('<meta name="robots" content="noindex">', false);
        $alternativeLang = $locale === LangEnum::RU ? LangEnum::EN : LangEnum::RU;
        $alternativeUrl = $this->routeService->getRouteArt($picture->id, true, $alternativeLang);
        $response->assertSee(
            "<link rel=\"alternate\" href=\"{$alternativeUrl}\" hreflang=\"{$alternativeLang}\">",
            false
        );
        $path = asset(getArtsFolder() . $file->path);
        $response->assertSee(
            "<meta property=\"og:image\" content=\"{$path}\">",
            false
        );
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testArtResponseCode404(string $locale): void
    {
        $this->app->setLocale($locale);

        $response = $this->followingRedirects()
            ->get('/art');

        $response->assertNotFound();
    }

}
