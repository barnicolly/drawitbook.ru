<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Tags\TagsService;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Validator;

class Content extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $viewData = [];
        $title =  'Drawitbook.ru - рисуйте, развлекайтесь, делитесь с друзьями';
        $description = 'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.';
        SEOTools::setTitle($title);
        $this->setShareImage(formDefaultShareArtUrlPath(true));
        SEOTools::setDescription($description);
        return view('Content::main_page.index', $viewData);
    }

    public function tagList(Request $request)
    {
        try {
            $responseList = [];
            $tagList = (new TagsService())->getMostPopular();
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
