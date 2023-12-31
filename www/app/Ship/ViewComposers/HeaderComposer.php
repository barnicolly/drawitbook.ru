<?php

declare(strict_types=1);

namespace App\Ship\ViewComposers;

use App\Containers\Menu\Actions\GetCachedMenuTreeAction;
use Illuminate\View\View;

final readonly class HeaderComposer
{
    public function __construct(private GetCachedMenuTreeAction $getCachedMenuTreeAction)
    {
    }

    public function compose(View $view): void
    {
        $locale = app()->getLocale();
        $viewData = [
            'groups' => $this->getCachedMenuTreeAction->run($locale),
        ];
        $view->with($viewData);
    }
}
