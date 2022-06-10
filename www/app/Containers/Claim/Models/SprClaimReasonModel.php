<?php

namespace App\Containers\Claim\Models;

use App\Containers\Claim\Data\Factories\SprClaimReasonModelFactory;
use App\Containers\Claim\Enums\SprClaimReasonColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $reason
 *
 */
class SprClaimReasonModel extends CoreModel
{
    use HasFactory;

    protected $table = SprClaimReasonColumnsEnum::TABlE;

    public $timestamps = false;

    protected $fillable = [];

    protected static function newFactory(): SprClaimReasonModelFactory
    {
        return SprClaimReasonModelFactory::new();
    }
}
