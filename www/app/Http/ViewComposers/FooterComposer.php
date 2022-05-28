<?php

namespace App\Http\ViewComposers;

use App\Containers\Translation\Enums\LangEnum;
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
            'languages' => $this->getSelectLanguageOptions($locale),
        ];
        return $view->with($viewData);
    }

    private function getSelectLanguageOptions(string $selectedLocale): array
    {
        return [
            [
                'lang' => LangEnum::EN,
                'selected' => LangEnum::EN === $selectedLocale,
                'src' => 'en.png',
                'title' => 'English'
            ],
            [
                'lang' => LangEnum::RU,
                'selected' => LangEnum::RU === $selectedLocale,
                'src' => 'ru.png',
                'title' => 'Русский'
            ],
        ];
    }
}
