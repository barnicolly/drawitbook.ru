<?php

declare(strict_types=1);

namespace App\Containers\Translation\Data\Seeders;

use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Seeders\Seeder;
use Waavi\Translation\Models\Language;

class TranslatorLanguagesSeeder extends Seeder
{
    public function run(): void
    {
        Language::create(['locale' => LangEnum::EN, 'name' => 'English']);
        Language::create(['locale' => LangEnum::RU, 'name' => 'Русский']);
    }
}
