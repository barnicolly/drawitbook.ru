<?php

declare(strict_types=1);

namespace App\Containers\Search\Tests\Feature\Http\Controllers;

use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Search\Http\Controllers\SearchController;
use App\Containers\Tag\Tests\Traits\CreateTagTrait;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see SearchController::autocomplete()
 */
class AutocompleteAjaxControllerTest extends TestCase
{
    use CreatePictureWithRelationsTrait;
    use CreateTagTrait;

    private string $url = '/%s/search/autocomplete';

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testGetAutocompleteItemsOk(string $locale): void
    {
        $this->app->setLocale($locale);
        $tag = $this->createTag();
        $tagWithoutPicture = $this->createTag();
        $picture = $this->createPicture();
        $this->createPictureTag($picture, $tag);
        $response = $this->ajaxGet(sprintf($this->url, $locale));

        $response->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        'items',
                    ],
                ],
            );
        $result = $response->decodeResponseJson()['data']['items'];
        $this->assertEqualsCanonicalizing([$locale === LangEnum::RU ? $tag->name : $tag->name_en], $result);
    }
}
