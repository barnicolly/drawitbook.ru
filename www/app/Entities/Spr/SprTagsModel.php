<?php

namespace App\Entities\Spr;

use Illuminate\Database\Eloquent\Model;

class SprTagsModel extends Model
{
    protected $table = 'spr_tags';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function getBySeoName(string $tagSeoName, string $locale): ?array
    {
        if ($locale === 'en') {
            $select =  [
                'id',
                'name_en as name',
                'slug_en as seo',
            ];
        } else {
            $select =  [
                'id',
                'name',
                'seo',
            ];
        }
        $result = self::query()
            ->select($select)
            ->where(
                function ($query) use ($tagSeoName, $locale) {
                    if ($locale === 'en') {
                        $query->where('slug_en', $tagSeoName);
                    }
                    if ($locale === 'ru') {
                        $query->where('seo', $tagSeoName);
                    }
                }
            )
            ->getQuery()
            ->first();
        if ($result) {
            return (array) $result;
        }
        return null;
    }
}
