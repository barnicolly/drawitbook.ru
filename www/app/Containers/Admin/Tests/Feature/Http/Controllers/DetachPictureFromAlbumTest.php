<?php

namespace App\Containers\Admin\Tests\Feature\Http\Controllers;

use App\Containers\Admin\Http\Controllers\ArtController;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Vk\Services\Api\PhotoService;
use App\Containers\Vk\Services\Api\VkApi;
use App\Containers\Vk\Tests\Traits\CreateVkAlbumTrait;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see ArtController::detachPictureFromAlbum()
 */
class DetachPictureFromAlbumTest extends TestCase
{
    use CreatePictureWithRelationsTrait, CreateVkAlbumTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $mock = $this->createMock(VkApi::class);
        $this->app->bind(VkApi::class, function () use ($mock) {
            return $mock;
        });
    }

    private function formUrl(int $pictureId): string
    {
        return route('admin.posting.vk.album.detach', ['id' => $pictureId]);
    }

    public function testPageOk(): void
    {
        $this->actingAsAdmin();
        $vkAlbum = $this->createVkAlbum();
        $vkAlbumPicture = $this->createVkAlbumPicture($vkAlbum);

        $mock = $this->createMock(PhotoService::class);
        $mock->method('delete');
        $this->app->bind(PhotoService::class, function () use ($mock) {
            return $mock;
        });

        $data = [
            'id' => $vkAlbumPicture->picture_id,
            'album_id' => $vkAlbum->id,
        ];
        $response = $this->ajaxPost($this->formUrl($vkAlbumPicture->picture_id), $data);

        $response->assertOk()
            ->assertJsonStructure([]);

        $vkAlbumPictures = $vkAlbum->pictures();
        self::assertSame(0, $vkAlbumPictures->count());
    }

    public function testPageNotFoundPicture(): void
    {
        $this->actingAsAdmin();
        $vkAlbum = $this->createVkAlbum();

        $undefinedPictureId = 1111;
        $data = [
            'id' => $undefinedPictureId,
            'album_id' => $vkAlbum->id,
        ];
        $response = $this->ajaxPost($this->formUrl($undefinedPictureId), $data);

        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('id');
    }

    public function testPageNotFoundVkAlbumId(): void
    {
        $this->actingAsAdmin();
        $picture = $this->createPicture();

        $undefinedVkAlbumId = 1111;
        $data = [
            'id' => $picture->id,
            'album_id' => $undefinedVkAlbumId,
        ];
        $response = $this->ajaxPost($this->formUrl($picture->id), $data);

        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('album_id');
    }

    public function testPageUnauthorized(): void
    {
        $picture = $this->createPicture();

        $data = [];
        $response = $this->ajaxPost($this->formUrl($picture->id), $data);

        $response->assertUnauthorized();
    }

    public function testPageForbidden(): void
    {
        $this->actingAsUser();
        $picture = $this->createPicture();

        $data = [];
        $response = $this->ajaxPost($this->formUrl($picture->id), $data);

        $response->assertForbidden();
    }

}
