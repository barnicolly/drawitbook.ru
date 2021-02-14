<?php

namespace Tests\Providers;

class CommonProvider
{

    public function providerLanguages(): array
    {
        return [
            [
                'ru',
            ],
            [
                'en',
            ],
        ];
    }
}
