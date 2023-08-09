<?php

declare(strict_types=1);

namespace App\Containers\SocialMediaPosting\Tests\Traits;

use App\Containers\SocialMediaPosting\Models\SocialMediaPostingHistoryModel;

trait CreateSocialMediaPostingHistoryTrait
{
    public function createSocialMediaPostingHistory(): SocialMediaPostingHistoryModel
    {
        return SocialMediaPostingHistoryModel::factory()->create();
    }
}
