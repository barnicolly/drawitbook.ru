<?php

namespace App\Services\Route;

class RouteService
{

    public function getRouteHome(): string
    {
        $url = $this->route('home');
        return $this->postProcessing($url);
    }

    public function getRouteSearch(): string
    {
        $url = $this->route('search');
        return $this->postProcessing($url);
    }

    public function getRouteArt(int $id): string
    {
        $url = $this->route('art', ['id' => $id]);
        return $this->postProcessing($url);
    }

    public function getRouteArtsCell(): string
    {
        $url = $this->route('arts.cell');
        return $this->postProcessing($url);
    }

    public function getRouteArtsCellTagged(string $tag): string
    {
        $url = $this->route('arts.cell.tagged', ['tag' => $tag]);
        return $this->postProcessing($url);
    }

    private function postProcessing(string $url): string
    {
        return urldecode($url);
    }
//getLangRoute
    public function route($name, $parameters = [], $absolute = true, $lang = null)
    {
        /*
        * Remember the ajax routes we wanted to exclude from our lang system?
        * Check if the name provided to the function is the one you want to
        * exclude. If it is we will just use the original implementation.
        **/
//    if (Str::contains($name, ['ajax', 'autocomplete'])) {
//        return app('url')->route($name, $parameters, $absolute);
//    }

//Check if $lang is valid and make a route to chosen lang
        if ($lang && in_array($lang, config('translator.available_locales'))) {
            return app('url')->route($lang . '_' . $name, $parameters, $absolute);
        }

        $locale_prefix = config('app.locale');
        return app('url')->route($locale_prefix . '_' . $name, $parameters, $absolute);
    }

}
