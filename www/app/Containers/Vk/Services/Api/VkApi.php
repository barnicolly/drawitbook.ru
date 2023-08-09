<?php

declare(strict_types=1);

namespace App\Containers\Vk\Services\Api;

use ATehnix\VkClient\Client;

class VkApi
{
    public string $groupId;
    public Client $api;

    public function __construct()
    {
        // https://oauth.vk.com/authorize?client_id=6981825&display=page&scope=photos,groups,wall,offline&response_type=token&v=5.124&state=123456
        $this->groupId = config('vk.group_id');
        $accessKey = config('vk.secret');
        $this->api = new Client('5.124');
        $this->api->setDefaultToken($accessKey);
    }
}
