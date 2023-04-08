<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Art;

use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Rate\Models\LikesModel;
use App\Containers\Rate\Tests\Traits\CreateLikesTrait;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see \App\Containers\Picture\Http\Controllers\Art\RateAjaxController::like
 */
class RateAjaxControllerLikeTest extends TestCase
{
    use CreatePictureWithRelationsTrait;
    use CreateLikesTrait;
    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testLikeWithoutExistLikeRecordResponseOk(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();

        $url = $this->routeService->getRouteArt($picture->id) . '/like';
        $requestData = [
            'off' => 'false',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk()
            ->assertJsonStructure([]);
        /** @var LikesModel $like */
        $like = LikesModel::first();
        self::assertSame($picture->id, $like->picture_id);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testLikeNotExistPictureOk(string $locale): void
    {
        $this->app->setLocale($locale);
        $pictureId = 111111;

        $url = $this->routeService->getRouteArt($pictureId) . '/like';
        $requestData = [
            'off' => 'false',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertUnprocessable();
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testOffLikeWithExistLikeRecord(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();
        $this->createLike($picture);

        $url = $this->routeService->getRouteArt($picture->id) . '/like';
        $requestData = [
            'off' => 'true',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk();
        self::assertEmpty(LikesModel::all());
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testUndefinedOffStatus(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();

        $url = $this->routeService->getRouteArt($picture->id) . '/like';
        $requestData = [
            'off' => '1111',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('off');
    }

}
