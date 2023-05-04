<?php

namespace App\Containers\Menu\Actions;

use App\Containers\Menu\Tasks\GetSortedMenuTreeTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Cache;

class GetCachedMenuTreeAction extends Action
{
    public GetSortedMenuTreeTask $getDataTask;

    public function __construct()
    {
        $this->getDataTask = app(GetSortedMenuTreeTask::class);
    }

    public function run(string $locale): array
    {
        $cacheName = $locale . '.menu.categories';
        $results = Cache::get($cacheName);
        if (!$results) {
            $results = Cache::remember(
                $cacheName,
                config('cache.expiration'),
                fn (): array => $this->getDataTask->run($locale)
            );
        }
        return $results;
    }
}
