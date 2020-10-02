<?php

namespace App\Http\Modules\Database\Models\Moderate;

use Illuminate\Database\Eloquent\Model;

class PagesModel extends Model
{
    protected $table = 'new_pages';

    public $timestamps = false;

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setConnection('moderate');
    }

   /* public function queries()
    {
        return $this->belongsToMany('App\Http\Modules\Database\Models\Moderate\QueryModel', 'pages_query', 'page_id', 'query_id');
    }*/
}
