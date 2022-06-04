<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Data\Criteria\WhereTagIsPopularCriteria;
use App\Containers\Tag\Data\Criteria\WhereTagSlugEnIsNotNullCriteria;
use App\Containers\Tag\Data\Repositories\TagRepository;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

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
        $columns = new Collection();
        if ($locale === LangEnum::EN) {
            $columns->push(SprTagsColumnsEnum::NAME_EN . ' as name');
            $columns->push(SprTagsColumnsEnum::SLUG_EN . ' as seo');
        } else {
            $columns->push(SprTagsColumnsEnum::NAME);
            $columns->push(SprTagsColumnsEnum::SEO);
        }
        if ($locale === LangEnum::EN) {
            $this->repository->pushCriteria(new WhereTagSlugEnIsNotNullCriteria());
        }
        $this->repository->pushCriteria(new WhereTagIsPopularCriteria());
        return $this->repository->get($columns->toArray())->toArray();
    }
}


