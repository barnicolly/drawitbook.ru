<?php

declare(strict_types=1);

namespace App\Ship\Parents\Resources;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use App\Ship\Dto\PaginationDto;
use Illuminate\Http\Resources\Json\JsonResource as LaravelJsonResource;

final class JsonResource extends LaravelJsonResource
{
    private ?PaginationDto $paginationMetaDto = null;

    public function withPaginationMeta(PaginationDto $paginationDto): self
    {
        $this->paginationMetaDto = $paginationDto;
        return $this;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray(Request $request)
    {
        if ($this->paginationMetaDto) {
            $this->additional([
                'meta' => [
                    'pagination' => $this->paginationMetaDto,
                ],
            ]);
        }
        return parent::toArray($request);
    }
}
