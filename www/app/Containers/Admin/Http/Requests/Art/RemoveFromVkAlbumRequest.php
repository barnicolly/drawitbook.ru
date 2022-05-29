<?php

namespace App\Containers\Admin\Http\Requests\Art;

use App\Ship\Parents\Requests\BaseFormRequest;

class RemoveFromVkAlbumRequest extends BaseFormRequest
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
