<?php

declare(strict_types=1);

namespace App\Containers\Tag\Tests\Feature\Http\Controllers;

use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Tag\Http\Controllers\TagAjaxController;
use App\Containers\Tag\Tests\Traits\CreateTagTrait;
use App\Ship\Parents\Tests\TestCase;
use Cache;

/**
 * @see TagAjaxController::getListPopularTagsWithCountArts()
 */
final class TagAjaxControllerTest extends TestCase
{
    use CreatePictureWithRelationsTrait;
    use CreateTagTrait;

    private string $url = '/ru/tag/list';

    public function testGetListPopularTagsWithCountArtsOk(): void
    {
        Cache::clear();
        $tag = $this->createTag();
        $picture = $this->createPicture();
        $this->createPictureTag($picture, $tag);
        $response = $this->ajaxGet($this->url);

        $response->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        'cloudItems',
                    ],
                ],
            );
    }
}
