<?php

namespace App\Containers\Tag\Actions;

use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\Tag\Data\Dto\TagDto;
use App\Containers\Tag\Models\TagsModel;
use App\Containers\Tag\Tasks\GetPopularTagsTask;
use App\Ship\Parents\Actions\Action;

class GetPopularTagsAction extends Action
{
    public function __construct(private readonly GetPopularTagsTask $getPopularTagsTask)
    {
    }

    /**
     * @throws RepositoryException
     */
    public function run(): array
    {
        $locale = app()->getLocale();
        return $this->getPopularTagsTask->run($locale)
            ->map(static fn (TagsModel $tag): array => TagDto::fromModel($tag, $locale)->toArray())
            ->toArray();
    }
}
