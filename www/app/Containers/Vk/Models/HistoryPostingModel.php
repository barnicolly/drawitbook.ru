<?php

namespace App\Containers\Vk\Models;

use App\Models\CoreModel;

class HistoryPostingModel extends CoreModel
{
//    todo-misha префикс таблицы vk спереди;
    public $timestamps = false;
    protected $dates = ['created_at'];
    protected $table = 'history_vk_posting';
    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
