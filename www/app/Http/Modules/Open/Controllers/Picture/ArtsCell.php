<?php

namespace App\Http\Modules\Open\Controllers\Picture;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use App\Libraries\Template;
use App\UseCases\Picture\CheckExistPictures;
use Illuminate\Support\Facades\Cache;
use MetaTag;
use Validator;

class ArtsCell extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $template = new Template();
        $pictures = Cache::remember('pictures.popular', 60 * 60, function () {
            return PictureModel::take(25)
                ->where('is_del', '=', 0)
                ->where('in_common', '=', IN_MAIN_PAGE)
                ->with(['tags'])->get();
        });
        $checkExistPictures = new CheckExistPictures($pictures);
        $pictures = $checkExistPictures->check();
        $viewData['relativePictures'] = $pictures;
        $title = 'Рисунки по клеточкам | Drawitbook.ru';
        $description = 'Рисунки по клеточкам. Схемы чёрно-белых и цветных рисунков от легких и простых до сложных.';
        MetaTag::set('title', $title);
        MetaTag::set('image', asset('arts/d4/11/d4113a118447cb7650a7a7d84b45b153.jpeg'));
        MetaTag::set('description', $description);
        return $template->loadView('Open::search.cell.index', $viewData);
    }

}
