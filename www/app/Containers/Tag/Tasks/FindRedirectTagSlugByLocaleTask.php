<?php

declare(strict_types=1);

namespace App\Containers\Tag\Tasks;

use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;

class FindRedirectTagSlugByLocaleTask extends Task
{
    public function __construct(private readonly GetTagBySeoNameTask $getTagBySeoNameTask)
    {
    }

    /**
     * @throws RepositoryException
     */
    public function run(string $locale, string $tagSlug): ?string
    {
        $alternativeLang = $locale === LangEnum::RU ? LangEnum::EN : LangEnum::RU;
        $tagInfo = $this->getTagBySeoNameTask->run($tagSlug, $alternativeLang);
        return $tagInfo->seo_lang->alternative->slug ?? null;
    }
}
