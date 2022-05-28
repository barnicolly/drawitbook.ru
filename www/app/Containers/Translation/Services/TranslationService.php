<?php

namespace App\Containers\Translation\Services;

use App\Containers\Translation\Enum\Lang;

class TranslationService
{

    public function __construct()
    {
    }

    public function getPluralForm(int $number, Lang $locale): string
    {
        return $locale->is(Lang::RU)
            ? pluralForm($number, ['рисунок', 'рисунка', 'рисунков'])
            : pluralFormEn($number, 'art', 'arts');
    }
}
