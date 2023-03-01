<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;

class FindRedirectTagSlugByLocaleTask extends Task
{
    private GetTagBySeoNameTask $getTagBySeoNameTask;

    public function __construct(GetTagBySeoNameTask $getTagBySeoNameTask)
    {
        $this->getTagBySeoNameTask = $getTagBySeoNameTask;
    }

    /**
     * @param string $locale
     * @param string $tagSlug
     * @return string|null
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(string $locale, string $tagSlug): ?string
    {
        $alternativeLang = $locale === LangEnum::RU ? LangEnum::EN : LangEnum::RU;
        $tagInfo = $this->getTagBySeoNameTask->run($tagSlug, $alternativeLang);
        return $tagInfo->seo_lang->alternative->slug ?? null;
    }
}


