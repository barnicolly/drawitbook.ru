<?php

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Arr;

class GetArtByIdAction extends Action
{

    public function __construct(private readonly GetArtsByIdsAction $getArtsByIdsAction)
    {
    }

    /**
     * @throws NotFoundPicture
     */
    public function run(int $id, bool $withHiddenTags = false): ?array
    {
        $arts = $this->getArtsByIdsAction->run([$id], $withHiddenTags);
        $art = Arr::first($arts);
        if (!$art) {
            throw new NotFoundPicture();
        }
        return $art;
    }

}


