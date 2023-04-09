<?php

namespace App\Containers\Vk\Services\Api;

use Exception;
class WallService
{

    public function __construct(protected VkApi $instance)
    {
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
        } catch (Exception) {
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
