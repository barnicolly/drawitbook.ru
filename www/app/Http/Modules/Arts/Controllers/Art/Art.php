<?php

namespace App\Http\Modules\Arts\Controllers\Art;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use App\Libraries\Template;
use App\UseCases\Picture\CheckExistPictures;
use App\UseCases\Picture\GetPicturesWithTags;
use App\UseCases\Picture\GetTagsFromPicture;
use App\UseCases\Search\SearchByTags;
use App\UseCases\User\GetIp;
use App\UseCases\Picture\GetPicture;
use App\UseCases\Picture\PictureViewed;
use MetaTag;

class Art extends Controller
{

    public function index($id)
    {
        $id = (int)$id;
        try {
            $getPicture = new GetPicture($id);
            $picture = $getPicture->getCached();

            $getTagsFromPictures = new GetTagsFromPicture();
            [$shown, $hidden] = $getTagsFromPictures->getTagIds($picture);
            $relativePictures = [];
            if ($shown || $hidden) {
                $search = new SearchByTags();
                $pictureIds = $search->searchRelatedPicturesIds($shown, $hidden);
                if ($pictureIds) {
                    $getPicturesWithTags = new GetPicturesWithTags($pictureIds);
                    $relativePictures = $getPicturesWithTags->get();
                    $checkExistPictures = new CheckExistPictures($relativePictures);
                    $relativePictures = $checkExistPictures->check();
                } else {
                    $pictures = PictureModel::take(10)
                        ->where('is_del', '=', 0)
                        ->where('in_common', '=', IN_MAIN_PAGE)
                        ->with(['tags'])->get();
                    $checkExistPictures = new CheckExistPictures($pictures);
                    $pictures = $checkExistPictures->check();
                    $relativePictures = $pictures;
                }
            }
            $tags = [];
            foreach ($picture->tags as $tag) {
                if ($tag->hidden === 0) {
                    $tags[] = mbUcfirst($tag->name);
                }
            }
            if ($tags) {
                $picture->alt = 'Рисунки по клеточкам ➣ ' . implode(' ➣ ', $tags);
            }
            if ($relativePictures) {
                foreach ($relativePictures as $index => $relativePicture) {
                    $tags = [];
                    foreach ($relativePicture->tags as $tag) {
                        if ($tag->hidden === 0) {
                            $tags[] = mbUcfirst($tag->name);
                        }
                    }
                    if ($tags) {
                        $relativePicture->alt = 'Рисунки по клеточкам ➣ ' . implode(' ➣ ', $tags);
                    }
                }
            }
            $viewData = ['picture' => $picture, 'relativePictures' => $relativePictures];
            $template = new Template();
            MetaTag::set('title', 'Art #' . $id . ' | Drawitbook.ru');
            MetaTag::set('robots', 'noindex');
            MetaTag::set('description', 'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.');
            MetaTag::set('image', asset('content/arts/' . $picture->path));
            $this->_commandsAfterView($id);
            return $template->loadView('Arts::art.index', $viewData);
        } catch (\Throwable $exception) {
            info($exception->getMessage());
            abort(500);
        }
    }

    private function _commandsAfterView(int $pictureId)
    {
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
