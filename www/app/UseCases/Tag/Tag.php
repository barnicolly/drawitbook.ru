<?php

namespace App\UseCases\Tag;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Tag
{

    public function __construct()
    {

    }

    public static function list()
    {

        $results = Cache::get('spr.tag_cloud');
        if (!$results) {
            $results = Cache::remember('spr.tag_cloud', config('cache.expiration'), function () {
                return DB::select(DB::raw('select spr_tags.name, spr_tags.seo, count(picture_tags.id) as c from spr_tags
    join picture_tags on picture_tags.tag_id = spr_tags.id
where hidden = 0
group by spr_tags.id
order by c desc
limit 40'));

            });
        }return $results;
    }
}
