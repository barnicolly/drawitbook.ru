<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\URL;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function setShareImage(string $relativeShareImgPath)
    {
        [$width, $height] = getimagesize(public_path($relativeShareImgPath));
        OpenGraph::addImage(asset($relativeShareImgPath), ['width' => $width, 'height' => $height]);
        $url = urldecode(URL::current());
        OpenGraph::setUrl($url);
        TwitterCard::setImage(asset($relativeShareImgPath));
        TwitterCard::setUrl($url);
    }
}
