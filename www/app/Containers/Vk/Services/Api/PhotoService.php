<?php

namespace App\Containers\Vk\Services\Api;

use Exception;
use GuzzleHttp\Client;

class PhotoService
{
    public function __construct(protected VkApi $instance)
    {
    }

    public function saveOnAlbum(string $filePath, int $albumId): ?int
    {
        $uploadUrl = $this->getAlbumUploadServer($albumId);
        $server = $this->upload($uploadUrl, $filePath);
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
        }
        throw new Exception();
    }

    public function timeout(): void
    {
        sleep(1);
    }

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
        } catch (Exception) {
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
            return null;
        } catch (Exception) {
            return null;
        }
    }

    public function delete(int $photoId): void
    {
        $data = [
            'owner_id' => '-' . $this->instance->groupId,
            'photo_id' => $photoId,
        ];
        $response = $this->instance->api->request('photos.delete', $data);
    }

    private function getWallUploadServer(): string
    {
        $response = $this->instance->api->request(
            'photos.getWallUploadServer',
            ['group_id' => $this->instance->groupId]
        );
        return $response['response']['upload_url'];
    }

    private function getAlbumUploadServer(int $albumId): string
    {
        $data = [];
        $data['album_id'] = $albumId;
        $data = [...$data, 'group_id' => $this->instance->groupId];
        $response = $this->instance->api->request('photos.getUploadServer', $data);
        return $response['response']['upload_url'];
    }

    private function upload(string $uploadUrl, string $filePath): array
    {
        $client = new Client();
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
        return json_decode($res->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
