<?php

declare(strict_types=1);

namespace App\Containers\Menu\Tasks;

use App\Containers\Menu\Data\Repositories\MenuLevelsRepository;
use App\Containers\Menu\Enums\MenuLevelsColumnsEnum;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Models\CoreModel;
use App\Ship\Parents\Tasks\Task;

final class GetAllMenuTask extends Task
{
    public function __construct(private readonly MenuLevelsRepository $repository)
    {
    }

    public function run(string $locale): array
    {
        $select = [
            MenuLevelsColumnsEnum::tId,
            MenuLevelsColumnsEnum::tPARENT_LEVEL_ID,
            MenuLevelsColumnsEnum::tCOLUMN,
        ];
        if ($locale === LangEnum::EN) {
            $select = [
                ...$select,
                TagsColumnsEnum::tNAME_EN . ' as name',
                TagsColumnsEnum::tSLUG_EN . ' as seo',
                MenuLevelsColumnsEnum::tCUSTOM_NAME_EN . ' as customName',
            ];
        } else {
            $select = [
                ...$select,
                TagsColumnsEnum::tNAME,
                TagsColumnsEnum::tSEO,
                MenuLevelsColumnsEnum::tCUSTOM_NAME_RU . ' as customName',
            ];
        }
        $result = $this->repository->getModel()
            ->select($select)
            ->where(
                static function ($query) use ($locale): void {
                    if ($locale === LangEnum::EN) {
                        $query->where(MenuLevelsColumnsEnum::tSHOW_EN, 1);
                    }
                    if ($locale === LangEnum::RU) {
                        $query->where(MenuLevelsColumnsEnum::tSHOW_RU, 1);
                    }
                },
            )
            ->leftJoin(TagsColumnsEnum::TABlE, TagsColumnsEnum::tID, '=', MenuLevelsColumnsEnum::tSPR_TAG_ID)
            ->orderBy(MenuLevelsColumnsEnum::tPARENT_LEVEL_ID, 'asc')
            ->getQuery()
            ->get()
            ->toArray();
        return CoreModel::mapToArray($result);
    }
}
