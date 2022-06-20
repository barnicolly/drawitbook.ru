<?php

namespace App\Containers\Admin\Tests\Feature\Http\Controllers;

use App\Containers\Admin\Http\Controllers\ArtController;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see ArtController::setVkPostingOff()
 */
class SetVkPostingOffTest extends TestCase
{
    use CreatePictureWithRelationsTrait;

    private string $url;

    protected function setUp(): void
    {
        parent::setUp();
        $this->url = route('admin.posting.vk.off');
    }

    public function testArtPageOk(): void
    {
        $this->actingAsAdmin();
        $picture = $this->createPicture();

        $data = [
            'id' => $picture->id,
        ];
        $response = $this->ajaxPost($this->url, $data);

        $response->assertOk()
            ->assertJsonStructure([]);
    }

    public function testArtPageNotFoundPicture(): void
    {
        $this->actingAsAdmin();

        $data = [
            'id' => 11111,
        ];
        $response = $this->ajaxPost($this->url, $data);

        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('id');
    }

    public function testArtPageWithoutPictureId(): void
    {
        $this->actingAsAdmin();

        $data = [];
        $response = $this->ajaxPost($this->url, $data);

        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('id');
    }

    public function testArtPageUnauthorized(): void
    {
        $picture = $this->createPicture();

        $data = [
            'id' => $picture->id,
        ];
        $response = $this->ajaxPost($this->url, $data);

        $response->assertUnauthorized();
    }

    public function testArtPageForbidden(): void
    {
        $this->actingAsUser();
        $picture = $this->createPicture();

        $data = [
            'id' => $picture->id,
        ];
        $response = $this->ajaxPost($this->url, $data);

        $response->assertForbidden();
    }

}
