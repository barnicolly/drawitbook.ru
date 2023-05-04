<?php

namespace App\Ship\Tests\Feature\ViewComposers;

use Illuminate\Testing\TestView;
use Illuminate\View\View;
use App\Containers\Menu\Enums\MenuLevelsColumnsEnum;
use App\Containers\Menu\Tests\Traits\CreateMenuLevelTrait;
use App\Containers\Tag\Models\SprTagsModel;
use App\Containers\Tag\Tests\Traits\CreateTagTrait;
use App\Ship\Parents\Tests\TestCase;
use App\Ship\ViewComposers\HeaderComposer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class HeaderComposerTest extends TestCase
{
    use CreateMenuLevelTrait;
    use CreateTagTrait;

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @see HeaderComposer
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

        $view = $this->view('layouts.public.header.index');

        /** @var View $innerView */
        $innerView = $this->getProtectedProperty($view, 'view');
        $innerViewData = $innerView->getData();

        $view->assertViewHas('groups');

        $tagCollections->each(static fn (SprTagsModel $tag): TestView => $view->assertSee($tag->name, false));
    }
}
