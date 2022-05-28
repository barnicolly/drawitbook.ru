<?php

namespace App\Containers\Translation\Tests\Providers;

use App\Containers\Translation\Enum\Lang;

class CommonProvider
{

    public function providerLanguages(): array
    {
        return [
            [
                Lang::RU,
            ],
            [
                Lang::EN,
            ],
        ];
    }
}
