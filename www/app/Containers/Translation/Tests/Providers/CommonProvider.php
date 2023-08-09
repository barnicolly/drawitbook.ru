<?php

declare(strict_types=1);

namespace App\Containers\Translation\Tests\Providers;

use App\Containers\Translation\Enums\LangEnum;

final class CommonProvider
{
    public static function providerLanguages(): array
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
