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
        MetaTag::set('title', 'Drawitbook.ru - рисуйте, развлекайтесь, делитесь с друзьями');
        MetaTag::set('image', asset('arts/d4/11/d4113a118447cb7650a7a7d84b45b153.jpeg'));
        MetaTag::set('description', 'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.');
        return $template->loadView('Open::search.cell.index', $viewData);
    }

}
