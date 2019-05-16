<?php

namespace App\Http\Modules\Cron\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\PostWallVkImage;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use ATehnix\VkClient\Client;

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

    public static function posting()
    {
        try {
            throw new \Exception('227');
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function postImage()
    {
        PostWallVkImage::dispatch(2651);
        return '1234';
    }

    private function _post()
    {
        //2585  2501 672 1671 2651
        $picture = PictureModel::with(['tags' => function ($q) {
            $q->where('spr_tags.hidden_vk', '=', 0);
        }])->find(2651);
        $path = base_path('public/arts/') . $picture->path;
        $tags = $picture->tags->pluck('name')->toArray();
        foreach ($tags as $key => $tag) {
            $tags[$key] = preg_replace('/\s+/', '', $tag);
        }

        $hashTags = '#рисунки #рисункипоклеточкам #' . implode(' #', $tags) . ' #drawitbook';
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
        $res = $this->_wallPost(['message' => $hashTags, 'attachments' => $attachments]);
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
        return $response;
    }

    private function _getUploadServer()
    {
        $response = $this->_api->request('photos.getWallUploadServer', ['group_id' => $this->_groupId]);
        return $response['response']['upload_url'];
    }
}
