<?php

namespace App\Containers\Picture\Http\Transformers\Cell;

use App\Containers\Picture\Data\Dto\GetCellTaggedResultDto;
use App\Ship\Parents\Transformers\Transformer;

final class GetCellTaggedArtsSliceTransformer extends Transformer
{

    public function transform(GetCellTaggedResultDto $data): array
    {
        return $data->toArray();
    }
}
