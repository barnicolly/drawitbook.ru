<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tasks\Task;

class SeparateTagsForHiddenAndShowIdsTask extends Task
{

    /**
     * @param array $artTags
     * @return array{array,array}
     */
    public function run(array $artTags): array
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


