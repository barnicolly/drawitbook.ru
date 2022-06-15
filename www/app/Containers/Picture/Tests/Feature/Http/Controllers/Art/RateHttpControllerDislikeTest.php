<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Art;

use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Rate\Enums\RateEnum;
use App\Containers\Rate\Enums\UserActivityColumnsEnum;
use App\Containers\Rate\Models\UserActivityModel;
use App\Containers\Rate\Tests\Traits\CreateUserActivityTrait;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see \App\Containers\Picture\Http\Controllers\Art\RateHttpController::dislike()
 */
class RateHttpControllerDislikeTest extends TestCase
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
    public function testWithoutUserActivityRecordResponseOk(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();

        $url = $this->routeService->getRouteArt($picture->id) . '/dislike';
        $requestData = [
            'off' => 'false',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk();
        /** @var UserActivityModel $userActivity */
        $userActivity = UserActivityModel::first();
        self::assertSame(RateEnum::DISLIKE, $userActivity->activity);
        self::assertSame($picture->id, $userActivity->picture_id);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testWithUserActivityRecordNoChangeActivity(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();
        $userActivity = $this->createUserActivity($picture, [UserActivityColumnsEnum::ACTIVITY => RateEnum::DISLIKE]);

        $url = $this->routeService->getRouteArt($picture->id) . '/dislike';
        $requestData = [
            'off' => 'false',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk();
        $userActivity->refresh();
        self::assertSame(RateEnum::DISLIKE, $userActivity->activity);
        self::assertSame($picture->id, $userActivity->picture_id);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testWithUserActivityRecordChangeActivity(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();
        $userActivity = $this->createUserActivity(
            $picture,
            [
                UserActivityColumnsEnum::ACTIVITY => RateEnum::LIKE,
            ]
        );

        $url = $this->routeService->getRouteArt($picture->id) . '/dislike';
        $requestData = [
            'off' => 'false',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk();
        $userActivity->refresh();
        self::assertSame(RateEnum::DISLIKE, $userActivity->activity);
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
                UserActivityColumnsEnum::ACTIVITY => RateEnum::DISLIKE,
            ]
        );

        $url = $this->routeService->getRouteArt($picture->id) . '/dislike';
        $requestData = [
            'off' => 'true',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk();
        self::assertEmpty(UserActivityModel::all());
    }

}
