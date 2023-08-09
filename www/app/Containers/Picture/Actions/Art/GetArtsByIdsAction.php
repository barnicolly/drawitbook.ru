<?php

declare(strict_types=1);

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Tasks\Picture\FormPicturesDtoTask;
use App\Containers\Picture\Tasks\Picture\GetPicturesByIdsTask;
use App\Ship\Parents\Actions\Action;

final class GetArtsByIdsAction extends Action
{
    public function __construct(
        private readonly GetPicturesByIdsTask $getPicturesByIdsTask,
        private readonly FormPicturesDtoTask $formPicturesDtoTask,
    ) {
    }

    public function run(array $ids, bool $withHiddenTags = false): array
    {
        $arts = $this->getPicturesByIdsTask->run($ids, $withHiddenTags);
        //        todo-misha заменить на коллекцию;
        return $this->formPicturesDtoTask->run($arts);
    }
}
