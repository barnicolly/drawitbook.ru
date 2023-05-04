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
    public function validateResolved(): void
    {
        $this->sanitize();
        parent::validateResolved();
    }

    abstract public function rules(): array;

    abstract public function authorize(): bool;

    public function withValidator(mixed $validator): void
    {
        $locale = app()->getLocale();
        $validator->getTranslator()->setLocale($locale);
    }

    protected function failedValidation(Validator $validator): void
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
