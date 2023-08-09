<?php

declare(strict_types=1);

namespace App\Ship\ViewComposers;

use App\Containers\Menu\Actions\GetCachedMenuTreeAction;
use App\Containers\Translation\Enums\LangEnum;
use Illuminate\View\View;

final readonly class FooterComposer
{
    public function __construct(private GetCachedMenuTreeAction $getCachedMenuTreeAction)
    {
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
