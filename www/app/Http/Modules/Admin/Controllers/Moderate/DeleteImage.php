<?php

namespace App\Http\Modules\Admin\Controllers\Moderate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Http\Modules\Database\Models\Moderate\PagesModel;

class DeleteImage extends Controller
{

    public function deleteImage(Request $request)
    {
        $image = PagesModel::find($request->input('id'));
        $image->is_del = 1;
        $image->save();
        return response(['success' => true]);
    }

    public function deleteImages(Request $request)
    {
        PagesModel::whereIn('id', $request->input('ids'))->update(['is_del' => 1]);
        return response(['success' => true]);
    }

}
