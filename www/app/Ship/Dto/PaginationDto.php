<?php

namespace App\Ship\Dto;

use App\Ship\Parents\Dto\Dto;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationDto extends Dto
{

    public int $page;

    public bool $hasMore;

    public int $total;

    public int $left;

    public static function createFromPaginator(LengthAwarePaginator $paginator): self
    {
        return new self(
            page: $paginator->currentPage(),
            total: $paginator->total(),
            left: $paginator->total() - ($paginator->perPage() * $paginator->currentPage()),
            hasMore: $paginator->hasMorePages(),
        );
    }
}
