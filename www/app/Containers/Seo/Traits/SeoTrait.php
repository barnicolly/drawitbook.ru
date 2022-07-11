<?php

namespace App\Containers\Seo\Traits;

use App\Containers\Seo\Dto\ShareImageDto;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\URL;

trait SeoTrait
{

    public function setMeta(
        string $title,
        ?string $description = null,
        ?string $keywords = null,
        ?string $robots = null
    ): self {
        $meta = $this->setTitle($title);
        if ($description) {
            $this->setDescription($description);
        }
        if ($keywords) {
            $this->setKeywords($keywords);
        }
        if ($robots) {
            $meta->setRobots($robots);
        }
        $this->setUrl();
        return $this;
    }

    public function setShareImage(?ShareImageDto $shareImageDto): self
    {
        if ($shareImageDto) {
            $absolutePath = asset($shareImageDto->relativePath);
            OpenGraph::addImage($absolutePath, ['width' => $shareImageDto->width, 'height' => $shareImageDto->height]);
            TwitterCard::setImage($absolutePath);
            TwitterCard::addValue('card', 'summary_large_image');
        }
        return $this;
    }

    public function setUrl(): self
    {
        $url = urldecode(URL::current());
        OpenGraph::setUrl($url);
        TwitterCard::setUrl($url);
        return $this;
    }

    public function setOpenGraphUrl(string $url): self
    {
        OpenGraph::setUrl($url);
        TwitterCard::setUrl($url);
        return $this;
    }

    public function setTitle(string $title): self
    {
        SEOTools::setTitle($title);
        return $this;
    }

    public function setCanonical(string $url): self
    {
        SEOTools::setCanonical($url);
        return $this;
    }

    private function setDescription(string $description): self
    {
        SEOTools::setDescription($description);
        return $this;
    }

    private function setKeywords(string $keywords): self
    {
        SEOMeta::setKeywords($keywords);
        return $this;
    }

    public function setRobots(string $robots): self
    {
        SEOMeta::setRobots($robots);
        return $this;
    }


}
