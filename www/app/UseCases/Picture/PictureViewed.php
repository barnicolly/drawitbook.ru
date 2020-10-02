<?php

namespace App\UseCases\Picture;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Raw\PictureViewModel as RawPictureViewModel;

class PictureViewed extends Controller
{

    protected $_ip;
    protected $_userId;
    protected $_pictureId;

    public function __construct($ip, int $userId, int $pictureId)
    {
        $this->_ip = $ip;
        $this->_userId = $userId;
        $this->_pictureId = $pictureId;
    }

    public function insert(): void
    {
        $rawView = new RawPictureViewModel();
        $rawView->picture_id = $this->_pictureId;
        $rawView->user_id = $this->_userId;
        $rawView->ip = $this->_ip;
        $rawView->save();
    }

}
