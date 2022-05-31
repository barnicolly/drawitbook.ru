<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Services\TagsService;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;

class FindRedirectTagSlugByLocaleTask extends Task
{

    private TagsService $tagsService;

    public function __construct(TagsService $tagsService)
    {
        $this->tagsService = $tagsService;
    }

    public function run(string $locale, string $initSlug): ?string
    {
        $alternativeLang = $locale === LangEnum::RU ? LangEnum::EN : LangEnum::RU;
        if ($locale === LangEnum::RU) {
            $tagInfo = $this->tagsService->getByTagSeoName($initSlug, $alternativeLang);
        } elseif ($locale === LangEnum::EN) {
            $tagInfo = $this->tagsService->getByTagSeoName($initSlug, $alternativeLang);
        }
        if (!empty($tagInfo)) {
            $tagInfo = $this->tagsService->getById($tagInfo['id']);
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


