<?php

namespace App\Containers\Translation\Tests\Unit\Services;

use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Ship\Parents\Tests\TestCase;

class TranslationServiceTest extends TestCase
{

    public function providerTestGetPluralForm(): array
    {
        return [
            [
                LangEnum::RU,
                5,
                'рисунков',
            ],
            [
                LangEnum::RU,
                11,
                'рисунков',
            ],
            [
                LangEnum::RU,
                22,
                'рисунка',
            ],
            [
                LangEnum::RU,
                1,
                'рисунок',
            ],
            [
                LangEnum::EN,
                1,
                'art',
            ],
            [
                LangEnum::EN,
                2,
                'arts',
            ],
            [
                LangEnum::EN,
                5,
                'arts',
            ],
            [
                LangEnum::EN,
                21,
                'arts',
            ],
        ];
    }

    /**
     * @dataProvider providerTestGetPluralForm
     */
    public function testGetPluralForm(string $locale, int $number, string $expectedPlural): void
    {
        $expected = implode(' ', [$number, $expectedPlural]);
        $result = (new TranslationService())->getPluralForm($number, LangEnum::fromValue($locale));
        $this->assertTrue($expected === $result);
    }

}
