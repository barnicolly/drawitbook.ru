<?php

namespace App\Modules\Content\Models;

use Illuminate\Database\Eloquent\Model;

class PicturesModel extends Model
{
    protected $table = 'pages';

    public $timestamps = false;

    protected $fillable = [

    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setConnection('mysql2');
    }
}
