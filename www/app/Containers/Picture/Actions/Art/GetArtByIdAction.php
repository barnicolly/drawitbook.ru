<?php

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Ship\Parents\Actions\Action;

class GetArtByIdAction extends Action
{

    private GetArtsByIdsAction $getArtsByIdsAction;

    public function __construct(GetArtsByIdsAction $getArtsByIdsAction)
    {
        $this->getArtsByIdsAction = $getArtsByIdsAction;
    }

    /**
     * @param int $id
     * @param bool $withHiddenTags
     * @return array|null
     * @throws NotFoundPicture
     */
    public function run(int $id, bool $withHiddenTags = false): ?array
    {
        $arts = $this->getArtsByIdsAction->run([$id], $withHiddenTags);
        $art = getFirstItemFromArray($arts);
        if (!$art) {
            throw new NotFoundPicture();
        }
        return $art;
    }

}


