<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class MasonryComponent extends BaseComponent
{
    /**
     * Get the root selector for the component.
     */
    public function selector(): string
    {
        return '.stack-grid-wrapper';
    }

    /**
     * Assert that the browser page contains the component.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@wrapper' => '.stack-grid-wrapper',
            '@downloadMoreButton' => '.download-more__btn',
            '@downloadMoreLeftCount' => '.left-arts-cnt',
        ];
    }

    public function clickReadMore(Browser $browser, int $resultCount): void
    {
        $browser->click('@downloadMoreButton')
            ->waitForTextIn('@downloadMoreLeftCount', $resultCount . ' РИСУНКОВ');
    }
}
