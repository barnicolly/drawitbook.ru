<?php

declare(strict_types=1);

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Data\Dto\TagDto;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Containers\Tag\Models\TagsModel;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Builder;

class GetTagBySeoNameTask extends Task
{
    public function run(string $tagSeoName, string $locale): ?TagDto
    {
        $result = TagsModel::query()
            ->when($locale === LangEnum::EN, static function (Builder $query) use ($tagSeoName): void {
                $query->where(TagsColumnsEnum::tSLUG_EN, '=', $tagSeoName);
            })
            ->when($locale === LangEnum::RU, static function (Builder $query) use ($tagSeoName): void {
                $query->where(TagsColumnsEnum::tSEO, '=', $tagSeoName);
            })
            ->first();
        if (!$result) {
            return null;
        }
        return TagDto::fromModel($result, $locale);
    }
}
