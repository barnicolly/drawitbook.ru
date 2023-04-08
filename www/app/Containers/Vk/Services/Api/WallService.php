<?php

namespace App\Containers\Vk\Services\Api;

class WallService
{

    protected VkApi $instance;

    public function __construct(VkApi $api)
    {
        //TODO-misha добавить exceptions;
        $this->instance = $api;
    }

    public function edit(int $postId, array $data): void
    {
        $data = array_merge(
            [
                'owner_id' => '-' . $this->instance->groupId,
                'post_id' => $postId,
            ],
            $data
        );
        try {
            $response = $this->instance->api->request('wall.edit', $data);
        } catch (\Exception $e) {
        }
    }

    public function create(array $data): ?int
    {
        $data = array_merge(
            [
                'owner_id' => '-' . $this->instance->groupId,
                'from_group' => 1,
                'close_comments' => 1,
            ],
            $data
        );
        $response = $this->instance->api->request('wall.post', $data);
        if ($response) {
            return $response['response']['post_id'];
        }
        return null;
    }

}
