<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Data\Criteria\WhereTagIdsCriteria;
use App\Containers\Tag\Data\Repositories\TagRepository;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Parents\Tasks\Task;
use Prettus\Repository\Exceptions\RepositoryException;

class GetTagsByIdsWithFlagsTask extends Task
{

    protected TagRepository $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $tagIds
     * @return array
     * @throws RepositoryException
     */
    public function run(array $tagIds): array
    {
        $this->repository->pushCriteria(new WhereTagIdsCriteria($tagIds));
        $result = $this->repository->with('flags')->get()->keyBy(SprTagsColumnsEnum::ID)->toArray();
        if ($result) {
            foreach ($result as $index => $item) {
                if (!empty($item['flags'])) {
                    $result[$index]['flags'] = array_column($item['flags'], 'name');
                }
            }
        }
        return $result;
    }
}


