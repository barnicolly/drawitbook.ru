<?php

namespace App\Services\Paginator;

class PaginatorService
{

    public function formSlice(array $relativePictureIds, int $pageNum): array
    {
        if ($relativePictureIds) {
            $perPage = DEFAULT_PER_PAGE;
            $countSearchResults = count($relativePictureIds);
            $countSlices = ($countSearchResults / $perPage) + 1;
            $isLastSlice = (int) $countSlices === $pageNum;
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
