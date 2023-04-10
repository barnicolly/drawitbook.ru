<?php

namespace App\Containers\Translation\Tests\Providers;

use App\Containers\Translation\Enums\LangEnum;

class CommonProvider
{
    public function providerLanguages(): array
    {
        return [
            [
                LangEnum::RU,
            ],
            [
                LangEnum::EN,
            ],
        ];
    }
}
