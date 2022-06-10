<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Art;

use App\Containers\Claim\Models\UserClaimModel;
use App\Containers\Claim\Tests\Traits\CreateClaimTrait;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see \App\Containers\Picture\Http\Controllers\Art\ClaimHttpController::register()
 */
class ClaimHttpControllerTest extends TestCase
{
    use CreatePictureWithRelationsTrait, CreateClaimTrait;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testResponseCode200(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();
        $sprClaimReason = $this->createSprClaimReason();

        $url = $this->routeService->getRouteArt($picture->id) . '/claim';
        $requestData = [
            'reason' => $sprClaimReason->id,
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk();
        /** @var UserClaimModel $userClaim */
        $userClaim = UserClaimModel::first();
        self::assertSame($userClaim->reason_id, $sprClaimReason->id);
        self::assertSame($userClaim->picture_id, $picture->id);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testNotFoundPicture(string $locale): void
    {
        $this->app->setLocale($locale);
        $sprClaimReason = $this->createSprClaimReason();
        $pictureId = 111111;

        $url = $this->routeService->getRouteArt($pictureId) . '/claim';
        $requestData = [
            'reason' => $sprClaimReason->id,
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertUnprocessable();
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testUndefinedClaimReason(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();

        $url = $this->routeService->getRouteArt($picture->id) . '/claim';
        $requestData = [
            'reason' => 111111,
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertUnprocessable();
    }

}
