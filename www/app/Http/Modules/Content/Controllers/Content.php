<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use App\Libraries\Template;
use Illuminate\Support\Facades\Cache;
use MetaTag;
use Validator;
use App\Http\Modules\Content\Controllers\Search;

class Content extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $template = new Template();
        $search = new Search();
        $pictures = Cache::remember('pictures.popular', 60 * 60, function () {
            return PictureModel::take(25)
                ->where('is_del', '=', 0)
                ->where('in_common', '=', IN_MAIN_PAGE)
                ->with(['tags'])->get();
        });
        $pictures = $search->checkExistArts($pictures);
        $viewData['pictures'] = $pictures;
        MetaTag::set('title', 'Drawitbook.ru - рисуйте, развлекайтесь, делитесь с друзьями');
        MetaTag::set('image', asset('arts/d4/11/d4113a118447cb7650a7a7d84b45b153.jpeg'));
        MetaTag::set('description', 'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.');
        return $template->loadView('Content::index', $viewData);
    }

    public function art($id)
    {
        $id = (int) $id;
        $picture = Cache::get('art.' . $id);
        if (!$picture) {
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
        return $template->loadView('Content::art.index', $viewData);
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
