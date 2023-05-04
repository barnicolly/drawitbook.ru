<?php

namespace Tests\Browser;

use App\Containers\Tag\Models\TagsModel;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\MasonryComponent;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PicturesLanding;
use Tests\DuskTestCase;

class HomePageTest extends DuskTestCase
{

    public function testHomePageOk(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage())
                ->assertSee('На сайте собрано около');
        });
    }

    public function testHomePageClickTagCloud(): void
    {
        /** @var TagsModel $tag */
        $tag = TagsModel::where('seo', 'medved')->first();

        $this->browse(function (Browser $browser) use ($tag) {
            $browser->visit(new HomePage());

            $browser->with('@tagContainer', function (Browser $table) use ($tag) {
                $table->waitForLink($tag->name)
                    ->clickLink($tag->name);
            });

            (new PicturesLanding($tag->seo))->assert($browser);

            $browser->within(new MasonryComponent(), function (Browser $browser) {
                $browser->clickReadMore(5);
            });
        });
    }
}
