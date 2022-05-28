<?php

namespace App\Containers\Admin\Http\Requests\Art;

use App\Http\Requests\BaseFormRequest;

class ArtSetVkPostingOffRequest extends BaseFormRequest
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
            'id' => 'required|integer',
        ];
    }

    public function filters()
    {
        return [
            'id' => 'cast:integer',
        ];
    }
}
