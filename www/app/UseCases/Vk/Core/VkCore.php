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
        $this->_key = '079d803758e75cf27ebf0d41fd280ab5aef30c1a2af76a831c9f5bb5d0da08d9e7ce6ee33f211deafc89a';
        $this->_groupId = '182256925';
        $this->_api = new Client('5.95');
        $this->_api->setDefaultToken($this->_key);
    }

}
