<?php

namespace App\Services\Tags;

use App\Entities\Picture\PictureModel;
use App\Entities\Spr\SprTagsModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TagsService
{

    public function __construct()
    {

    }

    public function extractTagsFromArt(PictureModel $art): array
    {
        $tags = [];
        foreach ($art->tags as $tag) {
            if ($tag->hidden === 0) {
                $tags[] = mbUcfirst($tag->name);
            }
        }
        return $tags;
    }

    public function getMostPopular(int $limit = 40)
    {

        $results = Cache::get('spr.tag_cloud');
        if (!$results) {
            $select = DB::raw("select spr_tags.name, spr_tags.seo, count(picture_tags.id) as c from spr_tags
    join picture_tags on picture_tags.tag_id = spr_tags.id
where hidden = 0
group by spr_tags.id
order by c desc
limit {$limit}");
            $results = Cache::remember('spr.tag_cloud', config('cache.expiration'), function () use ($select) {
                return DB::select($select);
            });
        }
        return $results;
    }

    public function getByTagSeoName(string $tagSeoName)
    {
        return SprTagsModel::where('seo', '=', $tagSeoName)->first();
    }

}

