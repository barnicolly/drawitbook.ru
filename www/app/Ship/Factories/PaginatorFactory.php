<?php

namespace App\Ship\Factories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class PaginatorFactory
{

    public const DEFAULT_PER_PAGE = 25;

    public static function createFromAnother(LengthAwarePaginator $paginator, Collection $items): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            $items,
            $paginator->total(),
            $paginator->perPage(),
            $paginator->currentPage(),
            $paginator->getOptions()
        );
    }

    public static function create(
        Collection $items,
        $perPage = self::DEFAULT_PER_PAGE,
        $page = null,
        $options = []
    ): LengthAwarePaginator {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
