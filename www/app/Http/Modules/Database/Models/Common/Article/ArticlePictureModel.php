<?php

namespace App\Http\Modules\Database\Models\Common\Article;

use Illuminate\Database\Eloquent\Model;

class ArticlePictureModel extends Model
{
    protected $table = 'article_pictures';

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

}
