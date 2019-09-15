<?php

namespace App\Http\Modules\Open\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use App\Libraries\Template;
use App\UseCases\Picture\CheckExistPictures;
use App\UseCases\Tag\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use MetaTag;
use Validator;

class Content extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $template = new Template();
        $viewData = [];
        MetaTag::set('title', 'Drawitbook.ru - рисуйте, развлекайтесь, делитесь с друзьями');
        MetaTag::set('image', asset('arts/d4/11/d4113a118447cb7650a7a7d84b45b153.jpeg'));
        MetaTag::set('description', 'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.');
        return $template->loadView('Open::index', $viewData);
    }

    public function tagList(Request $request)
    {
        try {
            $responseList = [];
            $tagList = Tag::list();
            foreach ($tagList as $tag) {
                $responseList[] = [
                    'link' => route('arts.cell.tagged', ['tag' => $tag->seo]),
                    'text' => $tag->name,
                    'weight' => $tag->c,
                ];
            }
            $result['success'] = true;
            $result['cloud_items'] = $responseList;
            return response($result);
        } catch (\Exception $e) {
            return response(['success' => false]);
        }
    }

}
