<?php

namespace App\Services\Posting;

class PostingService
{

    public function __construct()
    {
    }

    public function formHashTags(array $tags): string
    {
        foreach ($tags as $key => $tag) {
            $tags[$key] = preg_replace('/\s+/', '', $tag);
            $tags[$key] = str_ireplace('-', '', $tags[$key]);
        }
        $hashTags = '#рисунки #рисункипоклеточкам';
        if ($tags) {
            $hashTags .= ' #' . implode(' #', $tags);
        }
        $hashTags .= ' #drawitbook';
        return $hashTags;
    }

}

