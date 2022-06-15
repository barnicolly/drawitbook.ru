<?php

namespace App\Ship\Parents\Requests;

use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseFormRequest extends FormRequest
{
    use SanitizesInput;

    /**
     * For more sanitizer rule check https://github.com/Waavi/Sanitizer
     */
    public function validateResolved()
    {
        {
            $this->sanitize();
            parent::validateResolved();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    public function withValidator($validator): void
    {
        $locale = app()->getLocale();
        $validator->getTranslator()->setLocale($locale);
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->isJson() || $this->ajax()) {
            throw new HttpResponseException(
                response()->json(
                    [
                        'errors' => $validator->errors(),
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                )
            );
        }

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
