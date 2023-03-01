<?php

namespace App\Containers\Tag\Actions;

use App\Containers\Tag\Data\Dto\TagDto;
use App\Containers\Tag\Models\SprTagsModel;
use App\Containers\Tag\Tasks\GetPopularTagsTask;
use App\Ship\Parents\Actions\Action;

class GetPopularTagsAction extends Action
{

    private GetPopularTagsTask $getPopularTagsTask;

    public function __construct(GetPopularTagsTask $getPopularTagsTask)
    {
        $this->getPopularTagsTask = $getPopularTagsTask;
    }

    /**
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(): array
    {
        $locale = app()->getLocale();
        return $this->getPopularTagsTask->run($locale)
            ->map(fn(SprTagsModel $tag) => TagDto::fromModel($tag, $locale)->toArray())
            ->toArray();
    }

}


