<?php

namespace App\Http\Modules\Database\Models\Moderate;

use Illuminate\Database\Eloquent\Model;

class PagesModel extends Model
{
    protected $table = 'pages';

    public $timestamps = false;

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setConnection('moderate');
    }
}
