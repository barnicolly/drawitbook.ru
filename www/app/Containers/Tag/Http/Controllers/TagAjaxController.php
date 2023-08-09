<?php

declare(strict_types=1);

namespace App\Containers\Tag\Http\Controllers;

use App\Containers\Tag\Actions\GetListPopularTagsWithCountArtsAction;
use App\Containers\Tag\Data\Dto\GetListPopularTagsWithCountArtsResultDto;
use App\Ship\Parents\Controllers\HttpController;
use App\Ship\Parents\Resources\JsonResource;
use Illuminate\Http\JsonResponse;
use Throwable;

final class TagAjaxController extends HttpController
{
    /**
     * @see \App\Containers\Tag\Tests\Feature\Http\Controllers\TagAjaxControllerTest::testGetListPopularTagsWithCountArtsOk()
     */
    public function getListPopularTagsWithCountArts(
        GetListPopularTagsWithCountArtsAction $action,
    ): JsonResponse {
        try {
            $resultDto = new GetListPopularTagsWithCountArtsResultDto(
                [
                    'cloudItems' => $action->run(),
                ]
            );
            return JsonResource::make($resultDto)
                ->response();
        } catch (Throwable) {
            abort(500);
        }
    }
}
