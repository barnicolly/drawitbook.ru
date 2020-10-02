<?php

namespace App\Http\Modules\Cron\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Raw\HistoryVkPostingModel;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use ATehnix\VkClient\Client;
use Illuminate\Support\Facades\DB;

class Vk_album extends Controller
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
            try {
                $this->_post([2608]);
            } catch (\Exception $e) {

            }
    }

    private function _post(array $artIds)
    {
        $pictures = PictureModel::with(['tags' => function ($q) {
            $q->where('spr_tags.hidden_vk', '=', 0);
        }])->whereIn('id', $artIds)->get();

        $uploadUrl = $this->_getUploadServer();

        $url = 'tag[]=домашние животные';
        $url = 'https://drawitbook.ru/search?' . urlencode($url);
        $url = str_ireplace('%3D', '=', $url);

        foreach ($pictures as $picture) {
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

          /*  if (empty($payload[$picture->id])) {
                $payload[$picture->id] = [];
            }*/
//            $payload[$picture->id]['caption'] = $hashTags . '%0A' . 'Ещё больше рисунков на ' . $url;

        /*    $client = new \GuzzleHttp\Client();
            $res = $client->post($uploadUrl, [
                'multipart' => [
                    [
                        'name' => 'photo',
                        'contents' => fopen($path, 'r')
                    ],
                ],
            ]);
            $server = json_decode($res->getBody()->getContents(), true);*/
//            $payload[$picture->id] = ['id' => $server];

//            $photoId = $this->_savePhoto($server);
            $photoId = 456239067;

            $this->_editPhoto($photoId, ['caption' => $hashTags . "\n\n" . ' Ещё больше рисунков на ' . $url]);

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

    private function _savePhoto(array $photo)
    {
        $data = [
            'group_id' => $this->_groupId,
            'album_id' => 263036803,
            'photos_list' => $photo['photos_list'],
            'server' => $photo['server'],
            'hash' => $photo['hash'],
        ];
        try {
            $response = $this->_api->request('photos.save', $data);
            if ($response) {
                return $response['response'][0]['id'];
            }
        } catch (\Exception $e) {
            if ($data) {

            }
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
        $response = $this->_api->request('photos.getUploadServer', ['group_id' => $this->_groupId, 'album_id' => 263036803]);
        return $response['response']['upload_url'];
    }
}
