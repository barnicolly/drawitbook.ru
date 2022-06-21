<?php

namespace App\Containers\Admin\Http\Transformers;

use App\Containers\Admin\Data\Dto\GetSettingsModalResultDto;
use App\Ship\Parents\Transformers\Transformer;

final class GetSettingsModalTransformer extends Transformer
{

    public function transform(GetSettingsModalResultDto $dto): array
    {
        return $dto->toArray();
    }
}
