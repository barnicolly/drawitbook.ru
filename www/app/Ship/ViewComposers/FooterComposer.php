<?php

namespace App\Ship\ViewComposers;

use App\Containers\Menu\Services\MenuGroupService;
use App\Containers\Translation\Enums\LangEnum;
use Illuminate\View\View;

class FooterComposer
{
    private $menuGroupService;

    public function __construct()
    {
        $this->menuGroupService = (new MenuGroupService());
    }

    public function compose(View $view): View
    {
        $locale = app()->getLocale();
        $viewData = [
            'groups' => $this->menuGroupService->formCategoriesGroups($locale),
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
