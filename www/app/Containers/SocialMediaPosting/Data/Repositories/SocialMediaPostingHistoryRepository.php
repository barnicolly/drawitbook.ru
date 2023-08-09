<?php

declare(strict_types=1);

namespace App\Containers\SocialMediaPosting\Data\Repositories;

use App\Containers\SocialMediaPosting\Models\SocialMediaPostingHistoryModel;
use App\Ship\Parents\Repositories\Repository;

final class SocialMediaPostingHistoryRepository extends Repository
{
    public function model(): string
    {
        return SocialMediaPostingHistoryModel::class;
    }
}
