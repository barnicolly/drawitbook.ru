<?php

namespace App\Http\Modules\Cron\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Raw\HistoryVkPostingModel;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use ATehnix\VkClient\Client;
use Illuminate\Support\Facades\DB;

class Vk extends Controller
{

    protected $_key;
    protected $_groupId;
    protected $_api;

    public function __construct()
    {
        $this->_key = '079d803758e75cf27ebf0d41fd280ab5aef30c1a2af76a831c9f5bb5d0da08d9e7ce6ee33f211deafc89a';
        $this->_groupId = '182256925';
        $this->_api = new Client('5.95');
        $this->_api->setDefaultToken($this->_key);
    }

    public function posting()
    {
        $results = DB::select(DB::raw('select picture.id,
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
limit 1'));

        if ($results) {
            try {
                $artId = $results[0]->id;
                $this->_post($artId);
                $this->_addHistoryVkPosting($artId);
            } catch (\Exception $e) {

            }
        }
    }

    private function _addHistoryVkPosting(int $artId)
    {
        $historyVkPostingRecord = new HistoryVkPostingModel();
        $historyVkPostingRecord->picture_id = $artId;
        $historyVkPostingRecord->save();
    }

    private function _post(int $artId)
    {
        $picture = PictureModel::with(['tags' => function ($q) {
            $q->where('spr_tags.hidden_vk', '=', 0);
        }])->find($artId);
        $path = base_path('public/arts/') . $picture->path;
        $tags = $picture->tags->pluck('name')->toArray();
        foreach ($tags as $key => $tag) {
            $tags[$key] = preg_replace('/\s+/', '', $tag);
            $tags[$key] = str_ireplace('-', '', $tags[$key]);
        }

        $hashTags = '#рисунки #рисункипоклеточкам';
        if ($tags) {
            $hashTags .= ' #' . implode(' #', $tags);
        }
        $hashTags .= ' #drawitbook';
        $uploadUrl = $this->_getUploadServer();
        $client = new \GuzzleHttp\Client();
        $res = $client->post($uploadUrl, [
            'multipart' => [
                [
                    'name' => 'photo',
                    'contents' => fopen($path, 'r')
                ],
            ],
        ]);
        $server = json_decode($res->getBody()->getContents(), true);
        $uploadedPhoto = $this->_saveWallPhoto($server);
        $attachments = 'photo' . $uploadedPhoto['owner_id'] . '_' . $uploadedPhoto['id'] . ',' . 'https://drawitbook.ru';
        $postId = $this->_wallPost(['message' => $hashTags, 'attachments' => $attachments]);
        sleep(25);
        $lastWallPhotoId = $this->_getLastWallPhoto();
        if ($lastWallPhotoId) {
            $url = 'https://drawitbook.ru';
            $this->_editPhoto($lastWallPhotoId, ['caption' => $hashTags . "\n\n" . 'Ещё больше рисунков на ' . $url . "\n\n" . 'Рисуйте)']);


            $attachments = 'photo-' . $this->_groupId . '_' . $lastWallPhotoId . ',' . 'https://drawitbook.ru';
            $this->_editPost($postId, ['message' => $hashTags, 'attachments' => $attachments]);
        }
    }

    private function _editPost(int $postId, array $data)
    {
        $data = array_merge([
            'owner_id' => '-' . $this->_groupId,
            'post_id' => $postId,
        ], $data);
        try {
            $response = $this->_api->request('wall.edit', $data);
        } catch (\Exception $e) {
            if ($data) {

            }
        }
    }

    private function _editPhoto(int $photoId, array $data)
    {
        $data = array_merge([
            'owner_id' => '-' . $this->_groupId,
            'photo_id' => $photoId,
        ], $data);
        try {
            $response = $this->_api->request('photos.edit', $data);
        } catch (\Exception $e) {
            if ($data) {

            }
        }
    }

    private function _getLastWallPhoto()
    {
        $data = [
            'owner_id' => '-' . $this->_groupId,
            'album_id' => 'wall',
            'rev' => 1,
            'count' => 1,
        ];
        try {
            $response = $this->_api->request('photos.get', $data);
            return $response['response']['items'][0]['id'];
        } catch (\Exception $e) {
            if ($data) {

            }
        }
    }

    private function _saveWallPhoto(array $photo)
    {
        $data = [
            'group_id' => $this->_groupId,
            'photo' => $photo['photo'],
            'server' => $photo['server'],
            'hash' => $photo['hash'],
        ];
        $response = $this->_api->request('photos.saveWallPhoto', $data);
        if ($response) {
            return $response['response'][0];
        }
    }

    private function _wallPost(array $data)
    {
        $data = array_merge([
            'owner_id' => '-' . $this->_groupId, 'from_group' => 1
        ], $data);
        $response = $this->_api->request('wall.post', $data);
        if ($response) {
            return $response['response']['post_id'];
        }
    }

    private function _getUploadServer()
    {
        $response = $this->_api->request('photos.getWallUploadServer', ['group_id' => $this->_groupId]);
        return $response['response']['upload_url'];
    }
}
