<?php

namespace App\Entities\Vk;

use App\Models\CoreModel;

class HistoryPostingModel extends CoreModel
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
