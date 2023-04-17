<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Tests\Browser\Parents\Page;

class HomePage extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return '/ru';
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        //
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@tagContainer' => '#tagContainer',
        ];
    }
}
