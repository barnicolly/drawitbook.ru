<?php

namespace App\Http\Modules\Database\Models\Common\Raw;

use Illuminate\Database\Eloquent\Model;

class HistoryVkPostingModel extends Model
{
    public $timestamps = false;
    protected $dates = ['created_at'];
    protected $table = 'history_vk_posting';
    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
