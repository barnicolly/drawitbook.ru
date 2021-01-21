<?php

namespace App\Http\Modules\Arts\Controllers\Art;

use App\Entities\Picture\PictureModel;
use App\Http\Controllers\Controller;
use App\Services\Arts\ArtsService;
use App\Services\Arts\CheckExistPictures;
use App\Services\Arts\GetPicture;
use App\Services\Arts\GetPicturesWithTags;
use App\Services\Arts\GetTagsFromPicture;
use App\Services\Search\SearchService;
use App\Services\Seo\SeoService;
use App\Services\Tags\TagsService;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Database\Eloquent\Collection;

class Art extends Controller
{
    private $searchService;
    private $seoService;

    public function __construct(SearchService $searchService, SeoService $seoService)
    {
        $this->searchService = $searchService;
        $this->seoService = $seoService;
    }

    public function index(
        $id,
        TagsService $tagsService,
        ArtsService $artsService,
        GetTagsFromPicture $getTagsFromPictures
    ) {
        $id = (int) $id;
        $picture = (new GetPicture($id))->getCached();
        if (!$picture) {
            abort(404);
        }
        $relativePictures = $this->getRelativePictures($id, $getTagsFromPictures, $picture, $artsService);
        $this->seoService->setArtAlt($picture);
        if ($relativePictures) {
            $this->seoService->setArtsAlt($relativePictures);
        }
        $viewData = [
            'picture' => $picture,
            'relativePictures' => $relativePictures,
            'popularTags' => $tagsService->getPopular(),
            'tagged' => route('arts.cell.tagged', ''),
        ];
        [$title, $description] = (new SeoService())->formTitleAndDescriptionShowArt($id);
        SEOTools::setTitle($title);
        SEOTools::setDescription($description);
        SEOMeta::setRobots('noindex');
        $this->setShareImage(getArtsFolder() . $picture->path);
        return view('Arts::art.index', $viewData);
    }

    private function getRelativePictures(int $id, GetTagsFromPicture $getTagsFromPictures, PictureModel $picture, ArtsService $artsService): Collection
    {
        [$shown, $hidden] = $getTagsFromPictures->getTagIds($picture);
        $relativePictures = [];
        if ($shown || $hidden) {
            $pictureIds = $this->searchService->searchRelatedPicturesIds($shown, $hidden, $id);
            $relativePictures = $pictureIds
                ? $this->formRelativePictures($pictureIds)
                : $artsService->getInterestingArts($id);
        }
        return $relativePictures;
    }

    private function formRelativePictures(array $pictureIds): Collection
    {
        $relativePictures = (new GetPicturesWithTags($pictureIds))->get();
        return $relativePictures->isNotEmpty()
            ? (new CheckExistPictures($relativePictures))->check()
            : new Collection();
    }

}
