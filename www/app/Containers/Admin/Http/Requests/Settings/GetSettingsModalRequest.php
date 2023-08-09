<?php

declare(strict_types=1);

namespace App\Containers\Admin\Http\Requests\Settings;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Requests\BaseFormRequest;

/**
 * @property int $id
 */
final class GetSettingsModalRequest extends BaseFormRequest
{

    protected array $casts = [
        'id' => 'int',
    ];

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['id' => $this->route('id')]);
    }

    /**
     * @return array{id: string}
     */
    public function rules(): array
    {
        $pictureTable = PictureColumnsEnum::TABlE;
        return [
            'id' => "required|integer|exists:{$pictureTable},id",
        ];
    }
}
