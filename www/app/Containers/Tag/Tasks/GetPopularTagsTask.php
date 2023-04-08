<?php

namespace App\Containers\Tag\Tasks;

use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\Tag\Data\Criteria\WhereTagSlugEnIsNotNullCriteria;
use App\Containers\Tag\Data\Repositories\TagRepository;
use App\Containers\Tag\Models\SprTagsModel;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetPopularTagsTask extends Task
{

    public function __construct(protected TagRepository $repository)
    {
    }

    /**
     * @return Collection<SprTagsModel>
     * @throws RepositoryException
     */
    public function run(string $locale): Collection
    {
        if ($locale === LangEnum::EN) {
            $this->repository->pushCriteria(new WhereTagSlugEnIsNotNullCriteria());
        }
        return $this->repository->flagged(FlagsEnum::TAG_IS_POPULAR)->get();
    }
}


