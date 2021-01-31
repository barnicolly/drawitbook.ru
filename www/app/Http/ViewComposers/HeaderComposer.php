<?php

namespace App\Http\ViewComposers;

use App\Services\View\ViewService;
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
            'selectedLocale' => app()->getLocale(),
        ];
        return $view->with($viewData);
    }
}
