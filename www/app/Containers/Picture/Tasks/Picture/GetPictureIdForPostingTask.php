<?php

namespace App\Containers\Picture\Tasks\Picture;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\DB;

class GetPictureIdForPostingTask extends Task
{

    public function run(): ?int
    {
        //TODO-misha переписать на query;
        $results = DB::select(
            DB::raw(
                'select picture.id,
  IF(lastPostingDate.dayDiff IS NULL,
     IF((select DATEDIFF(NOW(), MAX(history_vk_posting.created_at)) as dayDiff
         from history_vk_posting
         group by picture_id
         order by dayDiff DESC
         limit 1) <= 10, 10 + 1, (select DATEDIFF(NOW(), MAX(history_vk_posting.created_at)) as dayDiff
                                  from history_vk_posting
                                  group by picture_id
                                  order by dayDiff DESC
                                  limit 1) + 1),
     lastPostingDate.dayDiff
  ) as dayDiff
from picture
  left join (select picture_id,
               MAX(history_vk_posting.created_at) as dateTime,
               COUNT(history_vk_posting.id),
               NOW(),
               DATEDIFF(NOW(), MAX(history_vk_posting.created_at)) as dayDiff
             from history_vk_posting
             group by picture_id) as lastPostingDate on picture.id = lastPostingDate.picture_id
where picture.in_vk_posting = 1
      and (lastPostingDate.dayDiff > 10 or lastPostingDate.dayDiff is null)
group by picture.id
order by dayDiff DESC
limit 1'
            )
        );
        if ($results) {
            return $results[0]->id;
        }
        return null;
    }
}


