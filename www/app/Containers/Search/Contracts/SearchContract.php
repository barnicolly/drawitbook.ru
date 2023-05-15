<?php

namespace App\Containers\Search\Contracts;

interface SearchContract
{
    public function getSearchIndex(): string;

    public function getSearchType(): string;

    public function toSearchArray(): array;
}
