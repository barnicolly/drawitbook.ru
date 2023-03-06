<?php

namespace App\Ship\Parents\Resources;

use App\Ship\Dto\PaginationDto;
use Illuminate\Http\Resources\Json\JsonResource as LaravelJsonResource;

class JsonResource extends LaravelJsonResource
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
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->paginationMetaDto) {
            $this->additional([
                'meta' => [
                    'pagination' => $this->paginationMetaDto,
                ]
            ]);
        }
        return parent::toArray($request);
    }
}
