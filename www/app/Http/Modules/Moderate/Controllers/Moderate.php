<?php

namespace App\Http\Modules\Moderate\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Moderate\Models\PicturesModel;

class Moderate extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $images = PicturesModel::take(100)
            ->get();
       /* $images = [
            '0a0a5148e2a7534fd7d72012eacd1688.jpeg',
            '0a0ada7ce36f11870ca83905ed2a8c99.jpeg',
            '0a0ae4d1ea4d0e2c9e2f5b12b6c65423.gif',
            '0a0bddc79e8e66c902b6718226447f24.jpeg',
            '0a0c747a42da67087e30febc15af5a0c.jpeg',
            '0a0ca90d26d661c00f35cc374fa6e8e1.png',
            '0a1bc47dd1463029a955e26a5540b6b0.png',
        ];*/
        return view('Content::compare', ['images' => $images]);
    }

}
