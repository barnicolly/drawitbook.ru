<?php

namespace App\Services\Paginator;

class PaginatorService
{

    //TODO-misha закрыть текстами определение последней страницы;
    public function formSlice(array $relativePictureIds, int $pageNum): array
    {
        if ($relativePictureIds) {
            $perPage = DEFAULT_PER_PAGE;
            $countSearchResults = count($relativePictureIds);
            $offset = $pageNum * $perPage;
            $isLastSlice = $offset >= $countSearchResults;
            $relativePictureIds = array_slice($relativePictureIds, ($pageNum - 1) * $perPage, $perPage);
            $countLeftPictures = $countSearchResults - ($perPage * $pageNum);
        } else {
            $countSearchResults = 0;
            $isLastSlice = false;
            $countLeftPictures = 0;
            $relativePictureIds = [];
        }
        return [$relativePictureIds, $countSearchResults, $isLastSlice, $countLeftPictures];
    }

}
