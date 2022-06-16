<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Art;

use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Rate\Enums\RateEnum;
use App\Containers\Rate\Enums\UserActivityColumnsEnum;
use App\Containers\Rate\Models\UserActivityModel;
use App\Containers\Rate\Tests\Traits\CreateUserActivityTrait;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see \App\Containers\Picture\Http\Controllers\Art\RateAjaxController::like
 */
class RateAjaxControllerLikeTest extends TestCase
{
    use CreatePictureWithRelationsTrait, CreateUserActivityTrait;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testLikeWithoutUserActivityRecordResponseOk(string $locale): void
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
        /** @var UserActivityModel $userActivity */
        $userActivity = UserActivityModel::first();
        self::assertSame(RateEnum::LIKE, $userActivity->activity);
        self::assertSame($picture->id, $userActivity->picture_id);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
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
     *
     * @param string $locale
     */
    public function testLikeWithUserActivityRecordNoChangeActivity(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();
        $userActivity = $this->createUserActivity($picture, [UserActivityColumnsEnum::ACTIVITY => RateEnum::LIKE]);

        $url = $this->routeService->getRouteArt($picture->id) . '/like';
        $requestData = [
            'off' => 'false',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk();
        $userActivity->refresh();
        self::assertSame(RateEnum::LIKE, $userActivity->activity);
        self::assertSame($picture->id, $userActivity->picture_id);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testOffLikeWithUserLikeActivityRecord(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();
        $this->createUserActivity(
            $picture,
            [
                UserActivityColumnsEnum::ACTIVITY => RateEnum::LIKE,
            ]
        );

        $url = $this->routeService->getRouteArt($picture->id) . '/like';
        $requestData = [
            'off' => 'true',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk();
        self::assertEmpty(UserActivityModel::all());
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
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
