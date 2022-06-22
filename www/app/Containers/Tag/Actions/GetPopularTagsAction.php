<?php

namespace App\Containers\Tag\Actions;

use App\Containers\Tag\Services\TagsService;
use App\Containers\Tag\Tasks\GetPopularTagsTask;
use App\Ship\Parents\Actions\Action;

class GetPopularTagsAction extends Action
{

    private TagsService $tagsService;
    private GetPopularTagsTask $getPopularTagsTask;

    public function __construct(TagsService $tagsService, GetPopularTagsTask $getPopularTagsTask)
    {
        $this->tagsService = $tagsService;
        $this->getPopularTagsTask = $getPopularTagsTask;
    }

    /**
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(): array
    {
        $locale = app()->getLocale();
        $popularTags = $this->getPopularTagsTask->run($locale);
        return $this->tagsService->setLinkOnTags($popularTags);
    }

}


