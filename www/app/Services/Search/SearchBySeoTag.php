<?php

namespace App\Services\Search;

use App\Entities\Spr\SprTagsModel;

class SearchBySeoTag
{
    private $_seoName = '';

    public function __construct(string $seoName)
    {
        $this->_seoName = $seoName;
    }

    public function search()
    {
        $tag = SprTagsModel::where('seo', '=', $this->_seoName)->first();

        return $tag;
    }

}