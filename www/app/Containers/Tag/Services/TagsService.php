<?php

namespace App\Containers\Tag\Services;

use App\Containers\Picture\Tasks\PictureTag\GetPictureTagsNamesWithoutHiddenVkByPictureIdTask;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Enums\FlagsEnum;

class TagsService
{
    //    todo-misha вынести в модуль picture все что связано с ними, оставить только получение справочных данных;

    public function getNamesWithoutHiddenVkByArtId(int $artId): array
    {
        return app(GetPictureTagsNamesWithoutHiddenVkByPictureIdTask::class)->run($artId);
    }

    /**
     * @param array $artTags
     * @return array{array,array}
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function separateTagsForHiddenAndShowIds(array $artTags): array
    {
        $hidden = [];
        $shown = [];
        if (!empty($artTags)) {
            foreach ($artTags as $tag) {
                if (in_array(FlagsEnum::TAG_HIDDEN, $tag['flags'], true)) {
                    $hidden[] = $tag[SprTagsColumnsEnum::ID];
                } else {
                    $shown[] = $tag[SprTagsColumnsEnum::ID];
                }
            }
        }
        return [$shown, $hidden];
    }

}

