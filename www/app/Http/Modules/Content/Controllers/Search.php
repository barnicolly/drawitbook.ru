<?php

namespace App\Http\Modules\Content\Controllers;

use App\Exceptions\NotFoundRelativeArts;
use App\Http\Controllers\Controller;
use App\Services\Arts\ArtsService;
use App\Services\Arts\CheckExistPictures;
use App\Services\Arts\GetPicture;
use App\Services\Arts\GetPicturesWithTags;
use App\Services\Arts\GetTagsFromPicture;
use App\Services\Paginator\PaginatorService;
use App\Services\Search\SearchService;
use App\Services\Tags\TagsService;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Validator;
use Breadcrumbs;

class Search extends Controller
{

    public function index(Request $request)
    {
        $filters = $request->input();
        try {
            [$relativePictures, $countSearchResults, $isLastSlice, $countLeftPictures] = $this->searchByFilters(
                $filters,
                1
            );
        } catch (InvalidArgumentException $e) {
            return abort(404);
        }
        if (!$relativePictures) {
            $viewData['popularPictures'] = (new ArtsService())->getInterestingArts(0, 10);
        }
        $viewData['filters'] = $filters;
        $viewData['isLastSlice'] = $isLastSlice;
        $viewData['countLeftPictures'] = $countLeftPictures;
        $viewData['countRelatedPictures'] = $countSearchResults;
        $viewData['pictures'] = $relativePictures;
        //TODO-misha добавить title;
        SEOTools::setTitle('Поиск по сайту');
        SEOMeta::setRobots('noindex, follow');
        return view('Content::search.index', $viewData)->render();
    }

    public function slice(Request $request)
    {
        //TODO-misha вынести и объединить с кодом из cell;
        $rules = [
            'page' => [
                'required',
                'integer',
            ],
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return abort(404);
        }
        $pageNum = (int) $request->input('page');
        try {
            [$relativePictures, $countSearchResults, $isLastSlice, $countLeftPictures] = $this->searchByFilters(
                $request->input(),
                $pageNum
            );
            if (!$relativePictures) {
                throw new NotFoundRelativeArts();
            }
            $viewData = [
                'page' => $pageNum,
                'isLastSlice' => $isLastSlice,
                'countLeftPictures' => $countLeftPictures,
                'pictures' => $relativePictures,
                'countRelatedPictures' => $countSearchResults,
                'tagged' => route('arts.cell.tagged', ''),
            ];
            $countLeftPicturesText = $countLeftPictures >= 0
                ? pluralForm($countLeftPictures, ['рисунок', 'рисунка', 'рисунков'])
                : '';
            $result = [
                'data' => [
                    'html' => view('Arts::template.stack_grid.elements', $viewData)->render(),
                    'page' => $pageNum,
                    'countLeftPicturesText' => $countLeftPicturesText,
                    'isLastSlice' => $isLastSlice,
                ],
            ];
        } catch (Throwable $e) {
            $result = [
                'error' => 'Произошла ошибка на стороне сервера',
            ];
        }
        return response($result);
    }

    private function searchByFilters(array $filters, int $pageNum)
    {
        $query = !empty($filters['query']) ? strip_tags($filters['query']) : '';
        $tags = $filters['tags'] ?? [];
        $targetSimilarId = $filters['similar'] ?? 0;
        $relativePictureIds = [];
        try {
            if ($query || $tags) {
                $tagIds = (new TagsService())->getByTagIdsByNames($tags);
                $relativePictureIds = (new SearchService(1000))->searchByQuery($query, $tagIds);
            } elseif ($targetSimilarId) {
                $picture = (new GetPicture($targetSimilarId))->getCached();
                [$shown, $hidden] = (new GetTagsFromPicture())->getTagIds($picture);
                if ($shown || $hidden) {
                    $relativePictureIds = (new SearchService(51))->searchRelatedPicturesIds($shown, $hidden);
                    if ($relativePictureIds) {
                        $relativePictureIds = array_diff($relativePictureIds, [$targetSimilarId]);
                    }
                }
            }
            if ($relativePictureIds) {
                [$relativePictures, $countSearchResults, $isLastSlice, $countLeftPictures] = $this->formSlice(
                    $relativePictureIds,
                    $pageNum
                );
            } else {
                throw new NotFoundRelativeArts();
            }
        } catch (NotFoundRelativeArts $e) {
            $relativePictures = [];
            $countSearchResults = 0;
        }
        $isLastSlice = $isLastSlice ?? false;
        $countLeftPictures = $countLeftPictures ?? 0;
        return [$relativePictures, $countSearchResults, $isLastSlice, $countLeftPictures];
    }

    private function formSlice(array $relativePictureIds, int $pageNum): array
    {
        [$relativePictureIds, $countSearchResults, $isLastSlice, $countLeftPictures] = (new PaginatorService())
            ->formSlice($relativePictureIds, $pageNum);
        if (!$relativePictureIds) {
            throw new NotFoundRelativeArts();
        }
        $relativePictures = (new GetPicturesWithTags($relativePictureIds))->get();
        $relativePictures = (new CheckExistPictures($relativePictures))->check();
        return [$relativePictures, $countSearchResults, $isLastSlice, $countLeftPictures];
    }
}

