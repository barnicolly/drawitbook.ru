<?php

namespace App\Services\Posting\Vk\Core;

use ATehnix\VkClient\Client;

class VkCore
{

    protected $_key;
    protected $_groupId;
    protected $_api;

    public function __construct()
    {
//        https://oauth.vk.com/authorize?client_id=6981825&display=page&scope=photos,groups&response_type=token&v=5.124&state=123456
        //TODO-misha скрыть api key
        $this->_key = 'a9047a422ed7cc98ceba1976dfebe8f42bac5611e597853364c66cd16e3fcd3725d96143231f5681e3f75';
        $this->_groupId = '182256925';
        $this->_api = new Client('5.124');
        $this->_api->setDefaultToken($this->_key);
    }

    protected function _getUploadServer(int $albumId = 0)
    {
        $data = [];
        if ($albumId) {
            $data['album_id'] = $albumId;
        }
        $data = array_merge($data, [
            'group_id' => $this->_groupId,
        ]);
        $response = $this->_api->request('photos.getUploadServer', $data);
        return $response['response']['upload_url'];
    }

    protected function _savePhoto(array $server, int $albumId)
    {
        $data = [
            'group_id' => $this->_groupId,
            'album_id' => $albumId,
            'photos_list' => $server['photos_list'],
            'server' => $server['server'],
            'hash' => $server['hash'],
        ];
        $response = $this->_api->request('photos.save', $data);
        if ($response) {
            return $response['response'][0]['id'];
        } else {
            throw new \Exception();
        }
    }

    protected function _uploadPhoto(string $uploadUrl, string $filePath)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->post($uploadUrl, [
            'multipart' => [
                [
                    'name' => 'photo',
                    'contents' => fopen($filePath, 'r')
                ],
            ],
        ]);
        return json_decode($res->getBody()->getContents(), true);
    }

    protected function _editPhoto(int $photoId, array $data)
    {
        $data = array_merge([
            'owner_id' => '-' . $this->_groupId,
            'photo_id' => $photoId,
        ], $data);
        $response = $this->_api->request('photos.edit', $data);
    }

    protected function _deletePhoto(int $photoId)
    {
        $data =[
            'owner_id' => '-' . $this->_groupId,
            'photo_id' => $photoId,
        ];
        $response = $this->_api->request('photos.delete', $data);
    }

}
