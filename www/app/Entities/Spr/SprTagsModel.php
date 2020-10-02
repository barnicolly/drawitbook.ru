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
}
