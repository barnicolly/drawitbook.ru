<?php

namespace App\Http\Modules\Arts\Controllers\Art;

use App\Http\Controllers\Controller;
use App\Services\Arts\ArtsService;
use App\Services\Arts\CheckExistPictures;
use App\Services\Arts\GetPicture;
use App\Services\Arts\GetPicturesWithTags;
use App\Services\Arts\GetTagsFromPicture;
use App\Services\Search\SearchService;
use App\Services\Seo\SeoService;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Database\Eloquent\Collection;

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
            $pictureIds = []; //$searchByTags->searchRelatedPicturesIds($shown, $hidden);
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
            'popularTags' => $this->getPopularTags(),
            'tagged' => route('arts.cell.tagged', ''),
        ];
        [$title, $description] = (new SeoService())->formTitleAndDescriptionShowArt($id);
        SEOTools::setTitle($title);
        SEOTools::setDescription($description);
        SEOMeta::setRobots('noindex');
        $this->setShareImage(getArtsFolder() . $picture->path);
        return view('Arts::art.index', $viewData);
    }

    private function getPopularTags(): array
    {
        return [
            'Мультфильмы' => 'iz-multfilma',
            'Животные' => 'zhivotnye',
            'Кошки' => 'koshka',
            'Собачки' => 'sobachka',
            'Супергерои' => 'supergeroi',
            'Единороги' => 'edinorog',
            'Девочки' => 'devochka',
            'Цветы' => 'cvety',
        ];
    }

    private function formRelativePictures(array $pictureIds): Collection
    {
        $relativePictures = (new GetPicturesWithTags($pictureIds))->get();
        return $relativePictures->isNotEmpty()
            ? (new CheckExistPictures($relativePictures))->check()
            : new Collection();
    }

}
