<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tasks\Task;

class SeparateTagsForHiddenAndShowIdsTask extends Task
{
    /**
     * @return array{array,array}
     */
    public function run(array $artTags): array
    {
        $hidden = [];
        $shown = [];
        if (!empty($artTags)) {
            foreach ($artTags as $tag) {
                if (in_array(FlagsEnum::TAG_HIDDEN, $tag['flags'], true)) {
                    $hidden[] = $tag[TagsColumnsEnum::ID];
                } else {
                    $shown[] = $tag[TagsColumnsEnum::ID];
                }
            }
        }
        return [$shown, $hidden];
    }
}
