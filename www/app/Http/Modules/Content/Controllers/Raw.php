<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Raw\PictureViewModel as RawPictureViewModel;
use Illuminate\Support\Facades\DB;
use Validator;

class Raw extends Controller
{

    public function insertUserView(int $pictureId): void
    {
        if (empty(session('is_admin'))) {
            $ip = request()->ip();
            $ip = DB::connection()->getPdo()->quote($ip);

            if (!in_array($ip, ['127.0.0.1'])) {
                $rawView = new RawPictureViewModel();
                $rawView->picture_id = $pictureId;
                $rawView->user_id = auth()->id();
                $rawView->ip = DB::raw("inet_aton($ip)");
                $rawView->save();
            }
        }
    }

}
