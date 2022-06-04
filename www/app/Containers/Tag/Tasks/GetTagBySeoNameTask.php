<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Data\Criteria\WhereTagSlugEnCriteria;
use App\Containers\Tag\Data\Criteria\WhereTagSlugRuCriteria;
use App\Containers\Tag\Data\Repositories\TagRepository;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

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
    public function run(string $tagSeoName, string $locale): ?array
    {
        $columns = new Collection();
        $columns->push(SprTagsColumnsEnum::ID);
        if ($locale === LangEnum::EN) {
            $columns->push(SprTagsColumnsEnum::NAME_EN . ' as name');
            $columns->push(SprTagsColumnsEnum::SLUG_EN . ' as seo');
        } else {
            $columns->push(SprTagsColumnsEnum::NAME);
            $columns->push(SprTagsColumnsEnum::SEO);
        }
        if ($locale === LangEnum::EN) {
            $this->repository->pushCriteria(new WhereTagSlugEnCriteria($tagSeoName));
        }
        if ($locale === LangEnum::RU) {
            $this->repository->pushCriteria(new WhereTagSlugRuCriteria($tagSeoName));
        }
        $result = $this->repository->first($columns->toArray());
        if (!$result) {
            return null;
        }
        return $result->toArray();
    }
}


