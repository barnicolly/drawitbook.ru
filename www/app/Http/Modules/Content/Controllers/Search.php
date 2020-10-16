<?php

namespace App\Http\Modules\Content\Controllers;

use App\Exceptions\NotFoundRelativeArts;
use App\Http\Controllers\Controller;
use App\Services\Arts\ArtsService;
use App\Services\Arts\CheckExistPictures;
use App\Services\Arts\GetPicture;
use App\Services\Arts\GetPicturesWithTags;
use App\Services\Arts\GetTagsFromPicture;
use App\Services\Search\SearchByQuery;
use App\Services\Search\SearchByTags;
use App\Services\Tags\TagsService;
use App\Services\Validation\SearchValidationService;
use Illuminate\Http\Request;
use MetaTag;
use Validator;
use Breadcrumbs;

class Search extends Controller
{

    public function index(Request $request)
    {
        $tags = $request->input('tag') ?? [];
        $targetSimilarId = $request->input('similar') ?? 0;
        $query = $request->input('query') ?? '';
        $filters = [
            'tags' => $tags,
            'query' => $query,
            'similar' => $targetSimilarId,
        ];
        if (!(new SearchValidationService())->validate($filters)) {
            abort(404);
        }
        $query = strip_tags($query);
        $relativePictureIds = [];
        try {
            if ($query || $tags) {
                $tagIds = (new TagsService())->getByTagIdsByNames($tags);
                $relativePictureIds = (new SearchByQuery())->searchByQuery($query, $tagIds);
            } elseif ($targetSimilarId) {
                $picture = (new GetPicture($targetSimilarId))->getCached();
                [$shown, $hidden] = (new GetTagsFromPicture())->getTagIds($picture);
                if ($shown || $hidden) {
                    $relativePictureIds = (new SearchByTags(51))->searchRelatedPicturesIds($shown, $hidden);
                    if ($relativePictureIds) {
                        $relativePictureIds = array_diff($relativePictureIds, [$targetSimilarId]);
                    }
                }
            }
            if ($relativePictureIds) {
                [$relativePictures, $countSearchResults] = $this->formSlice($relativePictureIds, 1);
            } else {
                throw new NotFoundRelativeArts();
            }
        } catch (NotFoundRelativeArts $e) {
            $relativePictures = [];
            $countSearchResults = 0;
        }
        if (!$relativePictures) {
            $viewData['popularPictures'] = (new ArtsService())->getInterestingArts(0, 10);
        }
        $viewData['filters'] = $filters;
        $viewData['countRelatedPictures'] = $countSearchResults;
        $viewData['relativePictures'] = $relativePictures;
        //TODO-misha добавить title;

        MetaTag::set('robots', 'noindex');
        return view('Content::search.index', $viewData)->render();
    }

    private function formSlice(array $relativePictureIds, int $page): array
    {
        $countSearchResults = count($relativePictureIds);
        $perPage = DEFAULT_PER_PAGE;
        $relativePictureIds = array_slice($relativePictureIds, ($page - 1) * $perPage, $perPage);
        if (!$relativePictureIds) {
            throw new NotFoundRelativeArts();
        }
        $relativePictures = (new GetPicturesWithTags($relativePictureIds))->get();
        $relativePictures = (new CheckExistPictures($relativePictures))->check();
        return [$relativePictures, $countSearchResults];
    }
}

