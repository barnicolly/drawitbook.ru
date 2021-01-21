<?php

namespace App\Services\Api\Vk\Core;

class PhotoService
{

    protected $instance;

    public function __construct(VkApi $api)
    {
        //TODO-misha добавить exceptions;
        $this->instance = $api;
    }

    /* public function getUploadServer(int $albumId = 0)
     {
         $data = [];
         if ($albumId) {
             $data['album_id'] = $albumId;
         }
         $data = array_merge(
             $data,
             [
                 'group_id' => $this->instance->groupId,
             ]
         );
         $response = $this->instance->api->request('photos.getUploadServer', $data);
         return $response['response']['upload_url'];
     }*/

    /* public function save(array $server, int $albumId)
     {
         $data = [
             'group_id' => $this->instance->groupId,
             'album_id' => $albumId,
             'photos_list' => $server['photos_list'],
             'server' => $server['server'],
             'hash' => $server['hash'],
         ];
         $response = $this->instance->api->request('photos.save', $data);
         if ($response) {
             return $response['response'][0]['id'];
         } else {
             throw new \Exception();
         }
     }*/

    public function edit(int $photoId, array $data): void
    {
        $data = array_merge(
            [
                'owner_id' => '-' . $this->instance->groupId,
                'photo_id' => $photoId,
            ],
            $data
        );
        $response = $this->instance->api->request('photos.edit', $data);
    }

    public function getLastOnWall(): ?int
    {
        $data = [
            'owner_id' => '-' . $this->instance->groupId,
            'album_id' => 'wall',
            'rev' => 1,
            'count' => 1,
        ];
        try {
            $response = $this->instance->api->request('photos.get', $data);
            return $response['response']['items'][0]['id'];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function saveWallPhoto(string $filePath): ?array
    {
        $uploadUrl = $this->getWallUploadServer();
        $server = $this->upload($uploadUrl, $filePath);
        $data = [
            'group_id' => $this->instance->groupId,
            'photo' => $server['photo'],
            'server' => $server['server'],
            'hash' => $server['hash'],
        ];
        try {
            $response = $this->instance->api->request('photos.saveWallPhoto', $data);
            if ($response) {
                return $response['response'][0];
            }
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getWallUploadServer()
    {
        $response = $this->instance->api->request('photos.getWallUploadServer', ['group_id' => $this->instance->groupId]);
        return $response['response']['upload_url'];
    }

    private function upload(string $uploadUrl, string $filePath)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->post(
            $uploadUrl,
            [
                'multipart' => [
                    [
                        'name' => 'photo',
                        'contents' => fopen($filePath, 'r'),
                    ],
                ],
            ]
        );
        return json_decode($res->getBody()->getContents(), true);
    }

    /*public function delete(int $photoId): void
    {
        $data = [
            'owner_id' => '-' . $this->instance->groupId,
            'photo_id' => $photoId,
        ];
        $response = $this->instance->api->request('photos.delete', $data);
    }*/

}
