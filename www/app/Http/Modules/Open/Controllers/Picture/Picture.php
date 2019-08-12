<?php

namespace App\Http\Modules\Open\Controllers\Picture;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\UseCases\Picture\CheckExistPictures;
use App\UseCases\Picture\GetPicturesWithTags;
use App\UseCases\Picture\GetTagsFromPicture;
use App\UseCases\Search\SearchByTags;
use App\UseCases\User\GetIp;
use App\UseCases\Picture\GetPicture;
use App\UseCases\Picture\PictureViewed;
use MetaTag;

class Picture extends Controller
{

    public function index($id)
    {
        $id = (int)$id;
        try {
            $getPicture = new GetPicture($id);
            $picture = $getPicture->getCached();

            $getTagsFromPictures = new GetTagsFromPicture();
            list($shown, $hidden) = $getTagsFromPictures->getTagIds($picture);
            $relativePictures = [];
            if ($shown || $hidden) {
                $search = new SearchByTags();
                $pictureIds = $search->searchRelatedPicturesIds($shown, $hidden);
                if ($pictureIds) {
                    $getPicturesWithTags = new GetPicturesWithTags($pictureIds);
                    $relativePictures = $getPicturesWithTags->get();
                    $checkExistPictures = new CheckExistPictures($relativePictures);
                    $relativePictures = $checkExistPictures->check();
                }
            }
            $viewData = ['picture' => $picture, 'relativePictures' => $relativePictures];
            $template = new Template();
            MetaTag::set('title', 'Art #' . $id . ' | Drawitbook.ru');
            MetaTag::set('robots', 'noindex');
            MetaTag::set('description', 'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.');
            MetaTag::set('image', asset('arts/' . $picture->path));
            $this->_commandsAfterView($id);
            return $template->loadView('Open::picture.index', $viewData);
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
