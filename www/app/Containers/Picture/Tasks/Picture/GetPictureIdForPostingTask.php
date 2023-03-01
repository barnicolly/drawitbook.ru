<?php

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\SocialMediaPosting\Exceptions\NotFoundPictureIdForPostingException;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\DB;

class GetPictureIdForPostingTask extends Task
{

    /**
     * @return int
     * @throws NotFoundPictureIdForPostingException
     */
    public function run(): int
    {
        $pictureIds = PictureModel::flagged(FlagsEnum::PICTURE_IN_VK_POSTING)->select([PictureColumnsEnum::tId])->get()->pluck(PictureColumnsEnum::ID)->toArray();
        if (!blank($pictureIds)) {
            $pictureIdsString = implode(',', $pictureIds);
            //TODO-misha переписать на query;
            $results = DB::select(
                DB::raw(
                    "select picture.id,
  IF(lastPostingDate.dayDiff IS NULL,
     IF((select DATEDIFF(NOW(), MAX(social_media_posting_history.created_at)) as dayDiff
         from social_media_posting_history
         group by picture_id
         order by dayDiff DESC
         limit 1) <= 10, 10 + 1, (select DATEDIFF(NOW(), MAX(social_media_posting_history.created_at)) as dayDiff
                                  from social_media_posting_history
                                  group by picture_id
                                  order by dayDiff DESC
                                  limit 1) + 1),
     lastPostingDate.dayDiff
  ) as dayDiff
from picture
  left join (select picture_id,
               MAX(social_media_posting_history.created_at) as dateTime,
               COUNT(social_media_posting_history.id),
               NOW(),
               DATEDIFF(NOW(), MAX(social_media_posting_history.created_at)) as dayDiff
             from social_media_posting_history
             group by picture_id) as lastPostingDate on picture.id = lastPostingDate.picture_id
where picture.id in ($pictureIdsString)
      and (lastPostingDate.dayDiff > 10 or lastPostingDate.dayDiff is null)
group by picture.id
order by dayDiff DESC
limit 1"
                )->getValue(DB::connection()->getQueryGrammar())
            );
            if ($results) {
                return $results[0]->id;
            }
        }
        throw new NotFoundPictureIdForPostingException();
    }
}


