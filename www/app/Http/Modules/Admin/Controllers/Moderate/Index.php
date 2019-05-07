<?php

namespace App\Http\Modules\Admin\Controllers\Moderate;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use Validator;
use App\Http\Modules\Database\Models\Moderate\PagesModel;


class Index extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $queryId = 4052;

        $countNonModeratedRecords = PagesModel::where('status', '=', 1)
            ->where('is_del', '=', 0)
            ->where('query_id', '=', $queryId)
            ->count();

        $template = new Template();
        $images = PagesModel::take(50)
            ->where('is_del', '=', 0)
            ->where('query_id', '=', $queryId)
            ->where('status', '=', 1)
            ->get();

        $viewData['countNonModeratedRecords'] = $countNonModeratedRecords;
        $viewData['images'] = $images;
        $viewData['popular'] = $this->_getHighlySpecializedTags();
        $viewData['defaultTags'] = [
            'фрукт',
        ];
        return $template->loadView('Admin::moderate.index', $viewData);
    }

    private function _getHighlySpecializedTags()
    {
        $tags = [
            'сложные',
            'красивые',
            'черно-белые',
            'интересные',
            'из мультфильма',
            'из фильма',
            'из игр',
        ];
        $tags = array_merge($tags, [
        ]);
        if (!$tags) {
            return $this->_popularTags();
        }
        return $tags;
    }

    private function _popularTags()
    {
        $popular = [
            'сложные',
            'красивые',
            'черно-белые',
            'для девочек',
            'прикольные',
            'интересные',
            'в тетради',
            'милые и няшные',
            'фрукт',
            'цветок',
            'большие',
            'аниме',
            'для мальчиков',
            'на 8 марта',
            'машина',
            'новый год',
            'графити',
            'гравити фолз',
            'карандашом',
            'девушка',
            'сердце',
            'из мультфильма',
        ];
//        sort($popular);
        return $popular;
    }


}
