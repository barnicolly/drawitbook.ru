<?php

namespace App\Entities\Article;

use Illuminate\Database\Eloquent\Model;

class ArticleModel extends Model
{
    protected $table = 'article';

    protected $fillable = [
        'template',
        'title',
        'description',
        'key_words',
        'link',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function pictures()
    {
        return $this->belongsToMany('App\Entities\Picture\PictureModel', 'article_pictures', 'article_id', 'picture_id')
            ->withPivot('caption', 'sort_id', 'id');
    }

}
