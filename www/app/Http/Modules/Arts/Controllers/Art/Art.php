<?php

namespace App\Http\Modules\Arts\Controllers\Art;

use App\Entities\Picture\PictureModel;
use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Services\Arts\ArtsService;
use App\Services\Arts\SeoService;
use App\Services\Tags\TagsService;
use App\UseCases\Picture\CheckExistPictures;
use App\UseCases\Picture\GetPicture;
use App\UseCases\Picture\GetPicturesWithTags;
use App\UseCases\Picture\GetTagsFromPicture;
use App\UseCases\Picture\PictureViewed;
use App\UseCases\Search\SearchByTags;
use App\UseCases\User\GetIp;
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
        try {
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
            $this->_commandsAfterView($id);
            return $template->loadView('Arts::art.index', $viewData);
        } catch (\Throwable $exception) {
            info($exception->getMessage());
            abort(500);
        }
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

    private function _commandsAfterView(int $pictureId)
    {
        //TODO-misha удалить статистику просмотров;
        if (empty(session('is_admin'))) {
            $id = auth()->id();
            $ip = request()->ip();
            if (!in_array($ip, ['127.0.0.1', '192.168.1.5'])) {
                $getIp = new GetIp($ip);
                $pictureViewed = new PictureViewed($getIp->inetAton(), ($id ? $id : 0), $pictureId);
                $pictureViewed->insert();
            }
        }
    }

}
