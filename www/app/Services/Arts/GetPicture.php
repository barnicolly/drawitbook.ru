<?php

namespace App\Services\Arts;

use App\Entities\Picture\PictureModel;
use Illuminate\Support\Facades\Cache;

class GetPicture
{

    //TODO-misha избавиться от класса;
    private $_id;
    private $_cacheName;
    protected $_withHiddenVkTag = false;

    public function __construct(int $id)
    {
        $this->_id = $id;
        $this->_cacheName = 'art.' . $id;
    }

    public function withHiddenVkTag()
    {
        $this->_withHiddenVkTag = true;
        return $this;
    }

    public function get()
    {
        $withHiddenVkTag = $this->_withHiddenVkTag;
        return PictureModel
            ::with(
                [
                    'tags' => function ($q) use ($withHiddenVkTag) {
                        if ($withHiddenVkTag) {
                            $q->where('spr_tags.hidden_vk', '=', 0);
                        }
                    },
                ]
            )
            ->where('is_del', '=', 0)
            ->find($this->_id);
    }

    public function getCached()
    {
        $picture = Cache::get($this->_cacheName);
        if (!$picture) {
            $picture = Cache::remember(
                $this->_cacheName,
                config('cache.expiration'),
                function () {
                    return $this->get();
                }
            );
        }
        return $picture;
    }

}
