<?php

namespace App\Containers\Tag\Http\Transformers;

use App\Containers\Tag\Data\Dto\GetListPopularTagsWithCountArtsResultDto;
use App\Ship\Parents\Transformers\Transformer;

final class GetListPopularTagsWithCountArtsTransformer extends Transformer
{

    public function transform(GetListPopularTagsWithCountArtsResultDto $data): array
    {
        return $data->toArray();
    }
}
