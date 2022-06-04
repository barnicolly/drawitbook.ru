<?php

namespace App\Containers\Picture\Tasks\PictureTag;

use App\Containers\Picture\Data\Criteria\PictureTag\JoinTagCriteria;
use App\Containers\Picture\Data\Repositories\PictureTagRepository;
use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Containers\Tag\Data\Criteria\WhereTagNotHiddenCriteria;
use App\Containers\Tag\Data\Criteria\WhereTagSlugEnIsNotNullCriteria;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetPictureTagsWithCountArtTask extends Task
{

    protected PictureTagRepository $repository;

    public function __construct(PictureTagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $limit
     * @param string $locale
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(int $limit, string $locale): array
    {
        $columns = new Collection();
        $columns->push(DB::raw('count("' . PictureTagsColumnsEnum::$tId . '") as count'));
        if ($locale === LangEnum::EN) {
            $columns->push(SprTagsColumnsEnum::$tNAME_EN . ' as name');
            $columns->push(SprTagsColumnsEnum::$tSLUG_EN . ' as seo');
        } else {
            $columns->push(SprTagsColumnsEnum::$tNAME);
            $columns->push(SprTagsColumnsEnum::$tSEO);
        }
        if ($locale === LangEnum::EN) {
            $this->repository->pushCriteria(new WhereTagSlugEnIsNotNullCriteria());
        }
        $this->repository->scopeQuery(function ($model) {
            return $model
                ->groupBy(SprTagsColumnsEnum::$tId)
                ->orderBy('count', 'desc');
        });
        return $this->repository->pushCriteria(new WhereTagNotHiddenCriteria())
            ->pushCriteria(new JoinTagCriteria())
            ->take($limit)
            ->get($columns->toArray())->toArray();
    }
}


