<?php

namespace App\Http\Modules\Arts\Controllers\Art;

use App\Entities\Picture\PictureModel;
use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Services\Arts\ArtsService;
use App\Services\Seo\SeoService;
use App\Services\Tags\TagsService;
use App\Services\Arts\CheckExistPictures;
use App\Services\Arts\GetPicture;
use App\Services\Arts\GetPicturesWithTags;
use App\Services\Arts\GetTagsFromPicture;
use App\Services\Search\SearchService;
use Illuminate\Database\Eloquent\Collection;
use MetaTag;

class Art extends Controller
{

    public function index(
        $id,
        SearchService $searchByTags,
        GetTagsFromPicture $getTagsFromPictures
    ) {
        $id = (int) $id;
        $picture = (new GetPicture($id))->getCached();
        if (!$picture) {
            abort(404);
        }
        [$shown, $hidden] = $getTagsFromPictures->getTagIds($picture);
        $relativePictures = [];
        if ($shown || $hidden) {
            $pictureIds = $searchByTags->searchRelatedPicturesIds($shown, $hidden);
            $relativePictures = $pictureIds
                ? $this->formRelativePictures($pictureIds)
                : (new ArtsService())->getInterestingArts($id);
        }
        (new SeoService())->setArtAlt($picture);
        if ($relativePictures) {
            foreach ($relativePictures as $index => $relativePicture) {
                (new SeoService())->setArtAlt($relativePicture);
            }
        }
        $viewData = [
            'picture' => $picture,
            'relativePictures' => $relativePictures,
        ];
        $template = new Template();
        [$title, $description] = (new SeoService())->formTitleAndDescriptionShowArt($id);
        MetaTag::set('title', $title);
        MetaTag::set('description', $description);
        MetaTag::set('robots', 'noindex');
        MetaTag::set('image', formArtUrlPath($picture->path));
        return $template->loadView('Arts::art.index', $viewData);
    }

    private function formRelativePictures(array $pictureIds): Collection
    {
        $relativePictures = (new GetPicturesWithTags($pictureIds))->get();
        return $relativePictures->isNotEmpty()
            ? (new CheckExistPictures($relativePictures))->check()
            : new Collection();
    }

}
