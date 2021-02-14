<?php

namespace Tests\Providers;

use App\Enums\Lang;

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
