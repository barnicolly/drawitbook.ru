<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Data\Repositories\TagRepository;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Containers\Tag\Models\TagsModel;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Criterias\WhereNotNullCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class GetPopularTagsTask extends Task
{
    public function __construct(protected TagRepository $repository)
    {
    }

    /**
     * @return Collection<TagsModel>
     *
     * @throws RepositoryException
     */
    public function run(string $locale): Collection
    {
        if ($locale === LangEnum::EN) {
            $this->repository->pushCriteria(new WhereNotNullCriteria(TagsColumnsEnum::tSLUG_EN));
        }
        return $this->repository->flagged(FlagsEnum::TAG_IS_POPULAR)->get();
    }
}
