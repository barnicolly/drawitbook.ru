<?php

namespace App\Containers\SocialMediaPosting\Data\Repositories;

use App\Containers\SocialMediaPosting\Models\SocialMediaPostingHistoryModel;
use App\Ship\Parents\Repositories\Repository;

class SocialMediaPostingHistoryRepository extends Repository
{
    public function model(): string
    {
        return SocialMediaPostingHistoryModel::class;
    }
}
