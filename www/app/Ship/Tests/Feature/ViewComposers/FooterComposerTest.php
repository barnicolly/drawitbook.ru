<?php

namespace App\Ship\Tests\Feature\ViewComposers;

use App\Containers\Menu\Enums\MenuLevelsColumnsEnum;
use App\Containers\Menu\Tests\Traits\CreateMenuLevelTrait;
use App\Containers\Tag\Models\SprTagsModel;
use App\Containers\Tag\Tests\Traits\CreateTagTrait;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tests\TestCase;
use App\Ship\ViewComposers\FooterComposer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class FooterComposerTest extends TestCase
{
    use CreateMenuLevelTrait, CreateTagTrait;

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     * @param string $locale
     * @see FooterComposer
     *
     */
    public function testViewHasKeys(string $locale): void
    {
        Cache::clear();
        $this->app->setLocale($locale);
        $parentTag1 = $this->createTag();
        $parentTag2 = $this->createTag();
        $subTag1 = $this->createTag();
        $subTag2 = $this->createTag();
        $menuItemParent1 = $this->createMenuLevel(
            [MenuLevelsColumnsEnum::SPR_TAG_ID => $parentTag1, MenuLevelsColumnsEnum::COLUMN => 1]
        );
        $this->createMenuLevel(
            [
                MenuLevelsColumnsEnum::SPR_TAG_ID => $subTag1,
                MenuLevelsColumnsEnum::COLUMN => 1,
                MenuLevelsColumnsEnum::PARENT_LEVEL_ID => $menuItemParent1,
            ]
        );
        $menuItemParent2 = $this->createMenuLevel(
            [MenuLevelsColumnsEnum::SPR_TAG_ID => $parentTag2->id, MenuLevelsColumnsEnum::COLUMN => 2]
        );
        $this->createMenuLevel(
            [
                MenuLevelsColumnsEnum::SPR_TAG_ID => $subTag2,
                MenuLevelsColumnsEnum::COLUMN => 1,
                MenuLevelsColumnsEnum::PARENT_LEVEL_ID => $menuItemParent2,
            ]
        );
        $tagCollections = new Collection([$parentTag1, $parentTag2, $subTag1, $subTag2]);

        $view = $this->view('layouts.public.footer.index');

        /** @var \Illuminate\View\View $innerView */
        $innerView = $this->getProtectedProperty($view, 'view');
        $innerViewData = $innerView->getData();

        $view->assertViewHas('groups')
            ->assertViewHas('languages');
        $languages = collect($innerViewData['languages']);
        $selectedLanguage = $languages->firstWhere(fn($item) => $item['selected']);
        $expectedLanguages = [LangEnum::EN, LangEnum::RU];
        self::assertEqualsCanonicalizing($expectedLanguages, $languages->pluck('lang')->toArray());
        self::assertEqualsCanonicalizing($locale, $selectedLanguage['lang']);

        $tagCollections->each(fn(SprTagsModel $tag) => $view->assertSee($tag->name, false));
    }
}
