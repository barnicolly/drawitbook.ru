<?php

namespace App\Containers\SocialMediaPosting\Tasks;

use App\Containers\SocialMediaPosting\Data\Repositories\SocialMediaPostingHistoryRepository;
use App\Containers\SocialMediaPosting\Models\SocialMediaPostingHistoryModel;
use App\Ship\Parents\Tasks\Task;

class CreateSocialMediaPostingItemTask extends Task
{

    protected SocialMediaPostingHistoryRepository $repository;

    public function __construct(SocialMediaPostingHistoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $artIdForPosting
     * @return SocialMediaPostingHistoryModel
     */
    public function run(int $artIdForPosting): SocialMediaPostingHistoryModel
    {
        $historyVkPostingRecord = new SocialMediaPostingHistoryModel();
        $historyVkPostingRecord->picture_id = $artIdForPosting;
        $historyVkPostingRecord->save();
        return $historyVkPostingRecord;
    }
}


