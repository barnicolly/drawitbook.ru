<?php

declare(strict_types=1);

namespace App\Ship\Services\Route;

class RouteService
{
    public function getRouteHome(array $parameters = [], bool $absolute = true, string $lang = null): string
    {
        $url = $this->route('home', $parameters, $absolute, $lang);
        return $this->postProcessing($url);
    }

    public function getRouteSearch(array $parameters = [], bool $absolute = true, string $lang = null): string
    {
        $url = $this->route('search', $parameters, $absolute, $lang);
        return $this->postProcessing($url);
    }

    public function getRouteArt(int $id, bool $absolute = true, string $lang = null): string
    {
        $url = $this->route('art', ['id' => $id], $absolute, $lang);
        return $this->postProcessing($url);
    }

    public function getRouteArtsCell(array $parameters = [], bool $absolute = true, string $lang = null): string
    {
        $url = $this->route('arts.cell', $parameters, $absolute, $lang);
        return $this->postProcessing($url);
    }

    public function getRouteArtsCellTagged(string $tag, bool $absolute = true, ?string $lang = null): string
    {
        $url = $this->route('arts.cell.tagged', ['tag' => $tag], $absolute, $lang);
        return $this->postProcessing($url);
    }

    private function postProcessing(string $url): string
    {
        return urldecode($url);
    }

    public function route(string $name, mixed $parameters = [], bool $absolute = true, string $lang = null): string
    {
        /*
        * Remember the ajax routes we wanted to exclude from our lang system?
        * Check if the name provided to the function is the one you want to
        * exclude. If it is we will just use the original implementation.
        */
        //    if (Str::contains($name, ['ajax', 'autocomplete'])) {
        //        return app('url')->route($name, $parameters, $absolute);
        //    }

        // Check if $lang is valid and make a route to chosen lang
        if ($lang && in_array($lang, config('translator.available_locales'), true)) {
            return app('url')->route($lang . '_' . $name, $parameters, $absolute);
        }

        $locale_prefix = config('app.locale');
        return app('url')->route($locale_prefix . '_' . $name, $parameters, $absolute);
    }
}
