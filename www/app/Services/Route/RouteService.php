<?php

namespace App\Services\Route;

class RouteService
{

    public function getRouteHome(): string
    {
        $url = route('home');
        return $this->postProcessing($url);
    }

    public function getRouteSearch(): string
    {
        $url = route('search');
        return $this->postProcessing($url);
    }

    public function getRouteArt(int $id): string
    {
        $url = route('art', ['id' => $id]);
        return $this->postProcessing($url);
    }

    public function getRouteArtsCell(): string
    {
        $url = route('arts.cell');
        return $this->postProcessing($url);
    }

    public function getRouteArtsCellTagged(string $tag): string
    {
        $url = route('arts.cell.tagged', ['tag' => $tag]);
        return $this->postProcessing($url);
    }

    private function postProcessing(string $url): string
    {
        return urldecode($url);
    }

}
