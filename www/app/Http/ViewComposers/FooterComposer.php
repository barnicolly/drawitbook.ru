<?php

namespace App\Http\ViewComposers;

use App\Services\View\ViewService;
use Illuminate\View\View;

class FooterComposer
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
