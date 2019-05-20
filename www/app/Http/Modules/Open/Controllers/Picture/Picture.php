<?php

namespace App\Http\Modules\Open\Controllers\Picture;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\UseCases\User\GetIp;
use App\UseCases\Picture\GetPicture;
use App\UseCases\Picture\PictureViewed;
use Illuminate\Support\Facades\Cache;
use MetaTag;
use Validator;

use Illuminate\Support\Facades\DB;

//use App\Http\Modules\Content\Controllers\Search;

class Picture extends Controller
{

    public function index($id)
    {
        $id = (int) $id;
        try {
            $getPicture = new GetPicture($id);
            $picture = $getPicture->get();
            $viewData = ['picture' => $picture, 'relativePictures' => []];
            $template = new Template();
            MetaTag::set('title', 'Art #' . $id . ' | Drawitbook.ru');
            MetaTag::set('robots', 'noindex');
            MetaTag::set('description', 'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.');
            MetaTag::set('image', asset('arts/' . $picture->path));
            $this->_commandsAfterView($id);
            return $template->loadView('Open::picture.index', $viewData);
        } catch (\Throwable $exception) {
            abort(404);
        }


//        $picture = Cache::get('art.' . $id);
      /*  if (!$picture) {
            $picture = Cache::remember('art.' . $id, config('cache.expiration'), function () use ($id) {
                return PictureModel::with(['tags'])
                    ->where('is_del', '=', 0)
                    ->findOrFail($id);
            });
        }
        list($shown, $hidden) = $this->_getTagIds($picture);
        $relativePictures = [];
        if ($shown || $hidden) {
            $search = new Search();
            $pictureIds = $search->searchRelatedPicturesIds($shown, $hidden);
            if ($pictureIds) {
                $relativePictures = PictureModel::with(['tags'])->whereIn('id', $pictureIds)->get();
                $relativePictures = $search->checkExistArts($relativePictures);
            }
        }
        $viewData = ['picture' => $picture, 'relativePictures' => $relativePictures];
        $template = new Template();
        $raw = new Raw();
        MetaTag::set('title', 'Art #' . $id . ' | Drawitbook.ru');
        MetaTag::set('robots', 'noindex');
        MetaTag::set('description', 'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.');
        MetaTag::set('image', asset('arts/' . $picture->path));
        $raw->insertUserView($picture->id);
        return $template->loadView('Content::art.index', $viewData);*/
    }

    private function _commandsAfterView(int $pictureId)
    {
        if (empty(session('is_admin'))) {
            $ip = request()->ip();
            if (!in_array($ip, ['127.0.0.1'])) {
                $getIp = new GetIp($ip);
                $pictureViewed = new PictureViewed($getIp->inetAton(), auth()->id(), $pictureId);
                $pictureViewed->insert();
            }
        }
    }

    private function _getTagIds(PictureModel $picture): array
    {
        $hidden = [];
        $shown = [];
        foreach ($picture->tags as $tag) {
            if ($tag->hidden === 1) {
                $hidden[] = $tag->id;
            } else {
                $shown[] = $tag->id;
            }
        }
        return [$shown, $hidden];
    }


}
