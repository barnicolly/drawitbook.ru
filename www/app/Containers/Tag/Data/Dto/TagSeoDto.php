<?php

namespace App\Containers\Tag\Data\Dto;

use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Dto\Dto;

class TagSeoDto extends Dto
{
    public LangEnum $locale;

    public ?string $slug = null;

    public ?string $name = null;
}
