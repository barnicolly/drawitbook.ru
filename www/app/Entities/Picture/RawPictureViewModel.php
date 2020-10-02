<?php

namespace App\Entities\Picture;

use Illuminate\Database\Eloquent\Model;

class RawPictureViewModel extends Model
{
    public $timestamps = false;
    protected $dates = ['created_at'];
    protected $table = 'raw_picture_views';
    protected $fillable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
