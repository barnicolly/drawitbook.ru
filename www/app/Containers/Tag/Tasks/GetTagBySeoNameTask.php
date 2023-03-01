<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Data\Criteria\WhereTagSlugEnCriteria;
use App\Containers\Tag\Data\Criteria\WhereTagSlugRuCriteria;
use App\Containers\Tag\Data\Dto\TagDto;
use App\Containers\Tag\Data\Repositories\TagRepository;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;

class GetTagBySeoNameTask extends Task
{

    protected TagRepository $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $tagSeoName
     * @param string $locale
     * @return array|null
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(string $tagSeoName, string $locale): ?TagDto
    {
        if ($locale === LangEnum::EN) {
            $this->repository->pushCriteria(new WhereTagSlugEnCriteria($tagSeoName));
        }
        if ($locale === LangEnum::RU) {
            $this->repository->pushCriteria(new WhereTagSlugRuCriteria($tagSeoName));
        }
        $result = $this->repository->first();
        if (!$result) {
            return null;
        }
        return TagDto::fromModel($result, $locale);
    }
}


