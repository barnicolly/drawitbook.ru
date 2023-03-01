<?php

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Tasks\Picture\FormPicturesDtoTask;
use App\Containers\Picture\Tasks\Picture\GetPicturesByIdsTask;
use App\Ship\Parents\Actions\Action;

class GetArtsByIdsAction extends Action
{

    private GetPicturesByIdsTask $getPicturesByIdsTask;
    private FormPicturesDtoTask $formPicturesDtoTask;

    public function __construct(GetPicturesByIdsTask $getPicturesByIdsTask, FormPicturesDtoTask $formPicturesDtoTask)
    {
        $this->getPicturesByIdsTask = $getPicturesByIdsTask;
        $this->formPicturesDtoTask = $formPicturesDtoTask;
    }

    /**
     * @param array $ids
     * @param bool $withHiddenTags
     * @return array
     */
    public function run(array $ids, bool $withHiddenTags = false): array
    {
        $arts = $this->getPicturesByIdsTask->run($ids, $withHiddenTags);
        return $this->formPicturesDtoTask->run($arts);
    }

}


