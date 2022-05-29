<?php

namespace App\Containers\Vk\Models;

use App\Containers\Vk\Enums\VkHistoryPostingColumnsEnum;
use App\Ship\Parents\Models\CoreModel;

/**
 * @property int $id
 * @property int $picture_id
 */
class HistoryPostingModel extends CoreModel
{
    //    todo-misha префикс таблицы vk спереди;
    public $timestamps = false;
    protected $dates = ['created_at'];
    protected $table = VkHistoryPostingColumnsEnum::TABlE;
    protected $fillable = [];
}
