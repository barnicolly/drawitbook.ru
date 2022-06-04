<?php

namespace App\Containers\Tag\Http\Controllers;

use App\Containers\Tag\Actions\GetListPopularTagsWithCountArtsAction;
use App\Containers\Tag\Data\Dto\GetListPopularTagsWithCountArtsResultDto;
use App\Containers\Tag\Http\Requests\GetListPopularTagsWithCountArtsAjaxRequest;
use App\Containers\Tag\Http\Transformers\GetListPopularTagsWithCountArtsTransformer;
use App\Ship\Parents\Controllers\HttpController;
use Illuminate\Http\JsonResponse;
use Throwable;

class TagAjaxController extends HttpController
{

    /**
     * @see \App\Containers\Tag\Tests\Feature\Http\Controllers\TagAjaxControllerTest::testGetListPopularTagsWithCountArtsOk()
     */
    public function getListPopularTagsWithCountArts(
        GetListPopularTagsWithCountArtsAction $action,
        GetListPopularTagsWithCountArtsAjaxRequest $request
    ): JsonResponse {
        try {
            $resultDto = new GetListPopularTagsWithCountArtsResultDto(
                [
                    'cloudItems' => $action->run(),
                ]
            );
            $result = fractal()->item($resultDto, new GetListPopularTagsWithCountArtsTransformer());
            return response()->json($result);
        } catch (Throwable $e) {
            abort(500);
        }
    }

}
