<?php

namespace Tests\Browser\Pages;

use App\Ship\Services\Route\RouteService;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class PicturesLanding extends Page
{

    private string $tag;

    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return (new RouteService())->getRouteArtsCellTagged($this->tag, false);
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@element' => '#selector',
        ];
    }
}
