<?php

namespace App\Containers\Tag\Data\Dto;

use App\Ship\Parents\Dto\Dto;

class TagDto extends Dto
{

    public int $id;

    public string $name;

    public string $seo;

//    todo-misha к dto;
    public string $link;

    public string $link_title;

    public array $flags;
}
