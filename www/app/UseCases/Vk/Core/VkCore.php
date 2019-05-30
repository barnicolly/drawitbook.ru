<?php

namespace App\UseCases\Vk\Core;

use ATehnix\VkClient\Client;

class VkCore
{

    protected $_key;
    protected $_groupId;
    protected $_api;

    public function __construct()
    {
        //TODO-misha скрыть api key
        $this->_key = 'd2c07ad4d74dcb74808356195ccec7db8c75b25c12106e632265a9e646b7d36588a0355ebe364f8bf4907';
        $this->_groupId = '182256925';
        $this->_api = new Client('5.95');
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

}
