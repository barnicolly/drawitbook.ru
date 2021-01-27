<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Seo\SeoService;
use App\Services\Tags\TagsService;
use Artesaos\SEOTools\Facades\SEOTools;

class Content extends Controller
{
    private $tagsService;
    private $seoService;

    public function __construct(TagsService $tagsService, SeoService $seoService)
    {
        $this->tagsService = $tagsService;
        $this->seoService = $seoService;
    }

    public function index()
    {
        $viewData = [];
        [$title, $description] = $this->seoService->formTitleAndDescriptionHome();
        SEOTools::setTitle($title);
        $this->setShareImage(formDefaultShareArtUrlPath(true));
        SEOTools::setDescription($description);
        return response()->view('Content::main_page.index', $viewData);
    }

    public function tagList()
    {
        try {
            $responseList = [];
            $tagList = $this->tagsService->getMostPopular(40);
            foreach ($tagList as $tag) {
                $responseList[] = [
                    'link' => route('arts.cell.tagged', ['tag' => $tag['seo']]),
                    'text' => $tag['name'],
                    'weight' => $tag['count'],
                ];
            }
            $result['success'] = true;
            $result['cloud_items'] = $responseList;
            return response()->json($result);
        } catch (\Exception $e) {
            return response(['success' => false]);
        }
    }

}
