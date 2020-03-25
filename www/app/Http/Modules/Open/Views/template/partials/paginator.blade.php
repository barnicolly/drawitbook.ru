@if (!isset($hideResultsCount) || !$hideResultsCount)
    <div class="d-inline">
        Результатов:
        <span class="badge badge-info">{{ $countRelatedPictures }}</span>
    </div>
@endif
@if ($paginate && ($paginate->lastPage() !== 1))
    <div class="d-inline">
        <p>
            Страница <span class="badge badge-info">{{ $paginate->currentPage() }}
                        из {{ $paginate->lastPage() }}</span>
        </p>
    </div>
@endif
@if ($paginate && ($paginate->lastPage() !== 1))
    <div>
        {{ $paginate->links() }}
    </div>
@endif
