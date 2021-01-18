<?php

namespace App\Traits;

trait BreadcrumbsTrait
{

    protected $breadcrumbs;

    protected function addBreadcrumb(string $title, ?string $url = null): void
    {
        $breadcrumb = new \stdClass();
        $breadcrumb->title = $title;
        $breadcrumb->url = $url;
        $this->breadcrumbs->push($breadcrumb);
    }

}
