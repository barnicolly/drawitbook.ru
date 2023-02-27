<?php

namespace App\Ship\ViewComposers;

use App\Containers\Menu\Actions\GetCachedMenuTreeAction;
use App\Containers\Translation\Enums\LangEnum;
use Illuminate\View\View;

class FooterComposer
{
    private GetCachedMenuTreeAction $getCachedMenuTreeAction;

    public function __construct(GetCachedMenuTreeAction $getCachedMenuTreeAction)
    {
        $this->getCachedMenuTreeAction = $getCachedMenuTreeAction;
    }

    public function compose(View $view): View
    {
        $locale = app()->getLocale();
        $viewData = [
            'groups' => $this->getCachedMenuTreeAction->run($locale),
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
                'title' => 'English',
            ],
            [
                'lang' => LangEnum::RU,
                'selected' => LangEnum::RU === $selectedLocale,
                'src' => 'ru.png',
                'title' => 'Русский',
            ],
        ];
    }
}
