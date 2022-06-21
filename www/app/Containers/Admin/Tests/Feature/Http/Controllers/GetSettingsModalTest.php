<?php

namespace App\Containers\Admin\Tests\Feature\Http\Controllers;

use App\Containers\Admin\Http\Controllers\ArtController;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see ArtController::getSettingsModal()
 */
class GetSettingsModalTest extends TestCase
{
    use CreatePictureWithRelationsTrait;

    protected function setUp(): void
    {
        parent::setUp();
    }

    private function formUrl(int $pictureId): string
    {
        return route('admin.picture.settings', ['id' => $pictureId]);
    }

    public function testArtPageOk(): void
    {
        $this->actingAsAdmin();
        $picture = $this->createPicture();

        $url = $this->formUrl($picture->id);
        $response = $this->ajaxGet($url);

        $response->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        'html',
                    ],
                ]
            );
    }

    public function testArtPageNotFoundPicture(): void
    {
        $this->actingAsAdmin();

        $url = $this->formUrl(11111);
        $response = $this->ajaxGet($url);

        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('id');
    }

    public function testArtPageUnauthorized(): void
    {
        $picture = $this->createPicture();

        $url = $this->formUrl($picture->id);
        $response = $this->ajaxGet($url);

        $response->assertUnauthorized();
    }

    public function testArtPageForbidden(): void
    {
        $this->actingAsUser();
        $picture = $this->createPicture();

        $url = $this->formUrl($picture->id);
        $response = $this->ajaxGet($url);

        $response->assertForbidden();
    }

}
