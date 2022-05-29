<?php

namespace App\Ship\ViewComposers;

use App\Ship\Services\View\ViewService;
use Illuminate\View\View;

class HeaderComposer
{

    private $viewService;

    public function __construct()
    {
        $this->viewService = (new ViewService());
    }

    public function compose(View $view): View
    {
        $locale = app()->getLocale();
        $viewData = [
            'groups' => $this->viewService->formCategoriesGroups($locale),
        ];
        return $view->with($viewData);
    }
}
