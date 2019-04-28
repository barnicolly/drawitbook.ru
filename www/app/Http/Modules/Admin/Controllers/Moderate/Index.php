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
        $countNonModeratedRecords = PagesModel::where('status', '=', 1)
            ->where('is_del', '=', 0)
            ->count();

        $template = new Template();
        $images = PagesModel::take(7)
            ->where('is_del', '=', 0)
            ->where('status', '=', 1)
            ->get();

        $viewData['countNonModeratedRecords'] = $countNonModeratedRecords;
        $viewData['images'] = $images;
        $viewData['popular'] = $this->_popularTags();
        return $template->loadView('Admin::moderate.index', $viewData);
    }

    private function _popularTags()
    {
        $popular = [
            'для девочек',
            'в тетради',
            'легкие',
            'фрукт',
            'цветок',
            'большие',
            'красивые',
            'для детей',
            'для дошкольников',
            'аниме',
            'черно-белые',
            'цветные',
            'для мальчиков',
            'на 8 марта',
            'машина',
            'новый год',
            'графити',
            'гравити фолз',
            'карандашом',
            'девушка',
            'прикольные',
            'интересные',
            'милые и няшные',
            'дом',
            'рыба',
            'прическа',
            'сердце',
        ];
        sort($popular);
        return $popular;
    }


}
