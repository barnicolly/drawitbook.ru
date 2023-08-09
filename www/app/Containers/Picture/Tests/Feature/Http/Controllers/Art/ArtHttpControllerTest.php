<?php

declare(strict_types=1);

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Art;

use Mockery\MockInterface;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Tag\Tests\Traits\CreateTagTrait;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Services\File\FileService;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see \App\Containers\Picture\Http\Controllers\Art\ArtHttpController::index()
 */
final class ArtHttpControllerTest extends TestCase
{
    use CreatePictureWithRelationsTrait;
    use CreateTagTrait;

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
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

        $this->mock(FileService::class, static function (MockInterface $mock) use ($file) : void {
            $mock
                ->shouldReceive('formArtUrlPath')
                ->andReturn($file->path);
        });

        $response = $this->get($this->routeService->getRouteArt($picture->id));

        $response->assertOk();
        $response->assertSee('<meta name="robots" content="noindex">', false);
        $alternativeLang = $locale === LangEnum::RU ? LangEnum::EN : LangEnum::RU;
        $alternativeUrl = $this->routeService->getRouteArt($picture->id, true, $alternativeLang);
        $response->assertSee(
            "<link rel=\"alternate\" href=\"{$alternativeUrl}\" hreflang=\"{$alternativeLang}\">",
            false,
        );
        $path = asset(getArtsFolder() . $file->path);
        $response->assertSee(
            "<meta property=\"og:image\" content=\"{$path}\">",
            false,
        );
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testArtResponseCode404(string $locale): void
    {
        $this->app->setLocale($locale);

        $response = $this->followingRedirects()
            ->get('/art');

        $response->assertNotFound();
    }
}
