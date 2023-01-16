<?php

namespace App\Containers\Tag\Tests\Feature\Http\Controllers;

use App\Containers\Tag\Http\Controllers\TagAjaxController;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see TagAjaxController::getListPopularTagsWithCountArts()
 */
class TagAjaxControllerTest extends TestCase
{

    private string $url = '/ru/tag/list';

    public function testGetListPopularTagsWithCountArtsOk(): void
    {
        $response = $this->ajaxGet($this->url);

        $response->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        'cloudItems',
                    ],
                ]
            );
    }

}
