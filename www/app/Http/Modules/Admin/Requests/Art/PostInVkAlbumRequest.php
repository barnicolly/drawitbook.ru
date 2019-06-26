<?php

namespace App\Http\Modules\Admin\Requests\Art;

use App\Http\Requests\BaseFormRequest;

class PostInVkAlbumRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'album_id' => 'required|integer',
        ];
    }

    public function filters()
    {
        return [
            'album_id' => 'cast:integer',
        ];
    }
}
