<?php

namespace App\Containers\Tag\Actions;

use App\Containers\Tag\Services\TagsService;
use App\Containers\Tag\Tasks\GetPopularTagsTask;
use App\Ship\Parents\Tasks\Task;

class GetPopularTagsAction extends Task
{

    private TagsService $tagsService;
    private GetPopularTagsTask $getPopularTagsTask;

    public function __construct(TagsService $tagsService, GetPopularTagsTask $getPopularTagsTask)
    {
        $this->tagsService = $tagsService;
        $this->getPopularTagsTask = $getPopularTagsTask;
    }

    public function run(): array
    {
        $locale = app()->getLocale();
        $popularTags = $this->getPopularTagsTask->run($locale);
        return $this->tagsService->setLinkOnTags($popularTags);
    }

}


