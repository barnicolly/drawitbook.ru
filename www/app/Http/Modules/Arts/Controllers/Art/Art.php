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
use App\Services\Search\SearchByTags;
use Illuminate\Database\Eloquent\Collection;
use MetaTag;

class Art extends Controller
{

    public function index(
        $id,
        SearchByTags $searchByTags,
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
        $this->setArtAlt($picture);
        if ($relativePictures) {
            foreach ($relativePictures as $index => $relativePicture) {
                $this->setArtAlt($relativePicture);
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
        //TODO-misha выделить путь к артам;
        MetaTag::set('image', asset('content/arts/' . $picture->path));
        return $template->loadView('Arts::art.index', $viewData);
    }

    private function formRelativePictures(array $pictureIds): Collection
    {
        $relativePictures = (new GetPicturesWithTags($pictureIds))->get();
        return $relativePictures->isNotEmpty()
            ? (new CheckExistPictures($relativePictures))->check()
            : new Collection();
    }

    private function setArtAlt(PictureModel $art)
    {
        $tags = (new TagsService)->extractTagsFromArt($art);
        if ($tags) {
            $art->alt = 'Рисунки по клеточкам ➣ ' . implode(' ➣ ', $tags);
        }
    }

}
