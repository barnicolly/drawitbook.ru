<?php

namespace App\Containers\Picture\Http\Requests\Cell;

use App\Ship\Parents\Requests\BaseFormRequest;

class CellArtsIndexHttpRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function filters()
    {
        return [];
    }
}