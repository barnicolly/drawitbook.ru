<?php

namespace App\Containers\Vk\Models;

use App\Containers\Vk\Enums\SocialMediaPostingHistoryColumnsEnum;
use App\Ship\Parents\Models\CoreModel;

/**
 * @property int $id
 * @property int $picture_id
 */
class SocialMediaPostingHistoryModel extends CoreModel
{
    public $timestamps = false;
    protected $dates = ['created_at'];
    protected $table = SocialMediaPostingHistoryColumnsEnum::TABlE;
    protected $fillable = [];
}
