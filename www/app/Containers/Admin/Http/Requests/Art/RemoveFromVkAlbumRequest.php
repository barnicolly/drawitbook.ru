<?php

namespace App\Containers\Admin\Http\Requests\Art;

use App\Ship\Parents\Requests\BaseFormRequest;

class RemoveFromVkAlbumRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'album_id' => 'required|integer',
        ];
    }

    public function filters(): array
    {
        return [
            'album_id' => 'cast:integer',
        ];
    }
}
