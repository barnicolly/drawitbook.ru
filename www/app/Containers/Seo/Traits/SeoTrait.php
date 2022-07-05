<?php

namespace App\Containers\Seo\Traits;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\URL;

trait SeoTrait
{

    public function setMeta(string $title, ?string $description = null, ?string $keywords = null, ?string $robots = null): self
    {
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
        return $this;
    }

//    todo-misha переделать на прием ДТО;
    public function setShareImage(string $relativeShareImgPath): self
    {
        if (file_exists(public_path($relativeShareImgPath))) {
            [$width, $height] = getimagesize(public_path($relativeShareImgPath));
            OpenGraph::addImage(asset($relativeShareImgPath), ['width' => $width, 'height' => $height]);
            TwitterCard::setImage(asset($relativeShareImgPath));
            TwitterCard::addValue('card', 'summary_large_image');
        }
//        todo-misha перенести установку url;
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
