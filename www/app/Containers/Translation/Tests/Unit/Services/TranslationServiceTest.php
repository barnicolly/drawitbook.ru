<?php

namespace App\Containers\Translation\Tests\Unit\Services;

use App\Containers\Translation\Enum\Lang;
use App\Containers\Translation\Services\TranslationService;
use Tests\TestCase;

class TranslationServiceTest extends TestCase
{

    public function providerTestGetPluralForm(): array
    {
        return [
            [
                Lang::RU,
                5,
                'рисунков',
            ],
            [
                Lang::RU,
                11,
                'рисунков',
            ],
            [
                Lang::RU,
                22,
                'рисунка',
            ],
            [
                Lang::RU,
                1,
                'рисунок',
            ],
            [
                Lang::EN,
                1,
                'art',
            ],
            [
                Lang::EN,
                2,
                'arts',
            ],
            [
                Lang::EN,
                5,
                'arts',
            ],
            [
                Lang::EN,
                21,
                'arts',
            ],
        ];
    }

    /**
     * @dataProvider providerTestGetPluralForm
     *
     * @param string $locale
     * @param int $number
     * @param string $expectedPlural
     */
    public function testGetPluralForm(string $locale, int $number, string $expectedPlural): void
    {
        $expected = implode(' ', [$number, $expectedPlural]);
        $result = (new TranslationService())->getPluralForm($number, Lang::fromValue($locale));
        $this->assertTrue($expected === $result);
    }

}
