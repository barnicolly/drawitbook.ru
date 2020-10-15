<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\Services\Tags\TagsService;
use App\UseCases\Tag\Tag;
use Illuminate\Http\Request;
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
        MetaTag::set('image', formDefaultShareArtUrlPath());
        MetaTag::set(
            'description',
            'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.'
        );
        return $template->loadView('Content::main_page.index', $viewData);
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
