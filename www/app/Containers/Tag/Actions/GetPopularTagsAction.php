<?php

namespace App\Containers\Tag\Actions;

use Prettus\Repository\Exceptions\RepositoryException;
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
     * @throws RepositoryException
     */
    public function run(): array
    {
        $locale = app()->getLocale();
        return $this->getPopularTagsTask->run($locale)
            ->map(fn(SprTagsModel $tag): array => TagDto::fromModel($tag, $locale)->toArray())
            ->toArray();
    }

}


