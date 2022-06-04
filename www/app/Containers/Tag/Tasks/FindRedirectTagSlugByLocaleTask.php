<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;

class FindRedirectTagSlugByLocaleTask extends Task
{
    private GetTagBySeoNameTask $getTagBySeoNameTask;
    private FindTagByIdTask $findTagByIdTask;

    public function __construct(GetTagBySeoNameTask $getTagBySeoNameTask, FindTagByIdTask $findTagByIdTask)
    {
        $this->getTagBySeoNameTask = $getTagBySeoNameTask;
        $this->findTagByIdTask = $findTagByIdTask;
    }

    public function run(string $locale, string $tagSlug): ?string
    {
        $alternativeLang = $locale === LangEnum::RU ? LangEnum::EN : LangEnum::RU;
        $tagInfo = $this->getTagBySeoNameTask->run($tagSlug, $alternativeLang);
        if (!empty($tagInfo)) {
            $tagInfo = $this->findTagByIdTask->run($tagInfo['id']);
            $slug = $locale === LangEnum::RU
                ? $tagInfo['seo']
                : $tagInfo['slug_en'];
            if ($slug) {
                return $slug;
            }
        }
        return null;
    }
}


