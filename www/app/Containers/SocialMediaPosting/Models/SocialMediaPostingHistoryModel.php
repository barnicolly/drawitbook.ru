<?php

declare(strict_types=1);

namespace App\Containers\SocialMediaPosting\Models;

use App\Containers\SocialMediaPosting\Data\Factories\SocialMediaPostingHistoryModelFactory;
use App\Containers\SocialMediaPosting\Enums\SocialMediaPostingHistoryColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $picture_id
 *
 * @method static SocialMediaPostingHistoryModelFactory factory
 */
class SocialMediaPostingHistoryModel extends CoreModel
{
    use HasFactory;

    public $timestamps = false;
    protected array $dates = ['created_at'];
    protected $table = SocialMediaPostingHistoryColumnsEnum::TABlE;
    protected $fillable = [];

    protected static function newFactory(): SocialMediaPostingHistoryModelFactory
    {
        return SocialMediaPostingHistoryModelFactory::new();
    }
}
