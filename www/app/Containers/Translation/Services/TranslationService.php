<?php

declare(strict_types=1);

namespace App\Containers\Translation\Services;

use App\Containers\Translation\Enums\LangEnum;

final class TranslationService
{
    public function getPluralForm(int $number, LangEnum $locale): string
    {
        return $locale->is(LangEnum::RU)
            ? pluralForm($number, ['рисунок', 'рисунка', 'рисунков'])
            : pluralFormEn($number, 'art', 'arts');
    }
}
