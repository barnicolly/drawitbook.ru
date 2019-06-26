<?php

namespace App\Entities\Article;

use Illuminate\Database\Eloquent\Model;

class ArticlePictureModel extends Model
{
    protected $table = 'article_pictures';

    protected $fillable = [];
    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

}
