<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Entities\Spr\SprTagsModel;
use App\Services\Arts\ArtsService;
use App\Services\Arts\CheckExistPictures;
use App\Services\Arts\GetPicture;
use App\Services\Arts\GetTagsFromPicture;
use App\Services\Search\SearchByQuery;
use App\Services\Search\SearchByTags;
use App\Services\Validation\SearchValidationService;
use Illuminate\Http\Request;
use App\Entities\Picture\PictureModel;
use MetaTag;
use Validator;
use Breadcrumbs;

class Search extends Controller
{

    public function index(Request $request)
    {
        $tags = $request->input('tag') ?? [];
        $targetSimilarId = $request->input('similar') ?? 0;
        if (is_string($tags)) {
            $tags = [$tags];
        }
        if (is_string($tags)) {
            $tags = [$tags];
        }
        $query = $request->input('query') ?? '';

        $data = [
            'tags' => $tags,
            'query' => $query,
            'similar' => $targetSimilarId,
        ];
        if (!(new SearchValidationService())->validate($data)) {
            abort(404);
        }
        $query = strip_tags($query);
        $relativePictures = [];
        $countSearchResults = 0;
        if ($query || $tags || $targetSimilarId) {
            if ($query || $tags) {
                //TODO-misha выделить в отдельный слой;
                $tagIds = $tags
                    ? SprTagsModel::whereIn('name', $tags)->pluck('id')->toArray()
                    : [];
                $relativePictureIds = (new SearchByQuery())->searchByQuery($query, $tagIds);
                if ($relativePictureIds) {
                    $countSearchResults = count($relativePictureIds);
                    $page = $request->input('page');
                    $perPage = DEFAULT_PER_PAGE;
                    if (!$page) {
                        $page = 1;
                    }
                    $relativePictureIds = array_slice($relativePictureIds, ($page - 1) * $perPage, $perPage);

                    if (!$relativePictureIds) {
                        abort(404);
                    }
                    //TODO-misha выделить;
                    $relativePictures = PictureModel::with(['tags'])
                        ->whereIn('id', $relativePictureIds)
                        ->get();

                    $relativePictures = (new CheckExistPictures($relativePictures))->check();
                }
            } elseif ($targetSimilarId) {
                $getPicture = new GetPicture($targetSimilarId);
                $picture = $getPicture->getCached();
                $getTagsFromPictures = new GetTagsFromPicture();
                [$shown, $hidden] = $getTagsFromPictures->getTagIds($picture);
                $relativePictures = [];
                if ($shown || $hidden) {
                    $search = new SearchByTags(51);
                    $relativePictureIds = $search->searchRelatedPicturesIds($shown, $hidden);
                    if ($relativePictureIds) {
                        $relativePictureIds = array_diff($relativePictureIds, [$targetSimilarId]);
                        $countSearchResults = count($relativePictureIds);
                        $page = $request->input('page');
                        $perPage = DEFAULT_PER_PAGE;
                        if (!$page) {
                            $page = 1;
                        }
                        $relativePictureIds = array_slice($relativePictureIds, ($page - 1) * $perPage, $perPage);

                        //TODO-misha выделить;
                        $relativePictures = PictureModel::with(['tags'])
                            ->whereIn('id', $relativePictureIds)
                            ->get();

                        $relativePictures = (new CheckExistPictures($relativePictures))->check();
                    } else {
                        abort(404);
                    }
                }
            }
            if (!$relativePictures) {
                $viewData['popularPictures'] = (new ArtsService())->getInterestingArts(0, 10);
            }
        }
        $viewData['filters'] = [
            'query' => $query,
            'tag' => $tags,
            'targetSimilarId' => $targetSimilarId,
        ];
        $viewData['countRelatedPictures'] = $countSearchResults;
        $viewData['relativePictures'] = $relativePictures;
        //TODO-misha добавить title;

        MetaTag::set('robots', 'noindex');
        return view('Content::search.index', $viewData)->render();
    }
}
