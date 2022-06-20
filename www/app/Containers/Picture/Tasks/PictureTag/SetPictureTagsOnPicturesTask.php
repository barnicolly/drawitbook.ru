<?php

namespace App\Containers\Picture\Tasks\PictureTag;

use App\Containers\Tag\Services\TagsService;
use App\Ship\Parents\Tasks\Task;

class SetPictureTagsOnPicturesTask extends Task
{

    private TagsService $tagsService;

    /**
     * @param TagsService $tagsService
     */
    public function __construct(TagsService $tagsService)
    {
        $this->tagsService = $tagsService;
    }

    /**
     * @param array $arts
     * @return array
     */
    public function run(array $arts): array
    {
        $artIds = array_column($arts, 'id');
        $tags = $this->tagsService->getTagsByArtIds($artIds, false);
        $tags = $this->tagsService->setLinkOnTags($tags);
        return $this->setTagsOnArts($arts, $tags);
    }

    private function setTagsOnArts(array $arts, array $tags): array
    {
        $tags = groupArray($tags, 'picture_id');
        foreach ($arts as $key => $art) {
            $artId = $art['id'];
            $arts[$key]['tags'] = $tags[$artId] ?? [];
        }
        return $arts;
    }
}


