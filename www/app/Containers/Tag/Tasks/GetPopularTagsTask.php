<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Data\Criteria\WhereTagSlugEnIsNotNullCriteria;
use App\Containers\Tag\Data\Repositories\TagRepository;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tasks\Task;

class GetPopularTagsTask extends Task
{

    protected TagRepository $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $locale
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(string $locale): array
    {
        if ($locale === LangEnum::EN) {
            $this->repository->pushCriteria(new WhereTagSlugEnIsNotNullCriteria());
        }
        $result = $this->repository->flagged(FlagsEnum::TAG_IS_POPULAR)->get()->toArray();
        if ($result) {
            foreach ($result as $index => $item) {
                $result[$index]['name'] = $item['seo_lang']->current->name;
            }
        }
        return $result;
    }
}


