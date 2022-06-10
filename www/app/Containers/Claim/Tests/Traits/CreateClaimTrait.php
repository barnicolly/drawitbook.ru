<?php

namespace App\Containers\Claim\Tests\Traits;

use App\Containers\Claim\Models\SprClaimReasonModel;

trait CreateClaimTrait
{

    public function createSprClaimReason(): SprClaimReasonModel
    {
        return SprClaimReasonModel::factory()->create();
    }
}
