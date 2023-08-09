<?php

declare(strict_types=1);

namespace App\Containers\Seo\Traits;

use stdClass;

trait BreadcrumbsTrait
{
    protected $breadcrumbs;

    protected function addBreadcrumb(string $title, ?string $url = null): void
    {
        $breadcrumb = new stdClass();
        $breadcrumb->title = $title;
        $breadcrumb->url = $url;
        $this->breadcrumbs->push($breadcrumb);
    }
}
