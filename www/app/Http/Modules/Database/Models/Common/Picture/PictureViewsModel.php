<?php

namespace App\Http\Modules\Database\Models\Common\Picture;

use Illuminate\Database\Eloquent\Model;

class PictureViewsModel extends Model
{
    protected $table = 'picture_views';
    public $timestamps = false;
    protected $dates = ['updated_at'];
    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

}
