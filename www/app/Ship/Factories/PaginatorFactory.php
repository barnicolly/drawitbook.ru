<?php

declare(strict_types=1);

namespace App\Ship\Factories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

final class PaginatorFactory
{
    /**
     * @var int
     */
    final public const DEFAULT_PER_PAGE = 25;

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
        ?int $perPage = self::DEFAULT_PER_PAGE,
        ?int $page = null,
        ?array $options = [],
    ): LengthAwarePaginator {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
