<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Data\Dto\TagDto;
use App\Containers\Tag\Data\Repositories\TagRepository;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Criterias\WhereStringCriteria;
use App\Ship\Parents\Tasks\Task;
use Prettus\Repository\Exceptions\RepositoryException;

class GetTagBySeoNameTask extends Task
{
    public function __construct(protected TagRepository $repository)
    {
    }

    /**
     * @throws RepositoryException
     */
    public function run(string $tagSeoName, string $locale): ?TagDto
    {
        if ($locale === LangEnum::EN) {
            $this->repository->pushCriteria(new WhereStringCriteria(TagsColumnsEnum::tSLUG_EN, $tagSeoName));
        } elseif ($locale === LangEnum::RU) {
            $this->repository->pushCriteria(new WhereStringCriteria(TagsColumnsEnum::tSEO, $tagSeoName));
        }
        $result = $this->repository->first();
        if (!$result) {
            return null;
        }
        return TagDto::fromModel($result, $locale);
    }
}
