<?php

namespace App\Containers\Search\Traits;

use Illuminate\Support\Str;

trait Searchable
{
    public function getSearchIndex(): string
    {
        $projectIndex = Str::lower(config('app.name')) . '.' . $this->getTable();
        return Str::replace('.', '-', $projectIndex);
    }

    public function getSearchType(): string
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }
        return $this->getTable();
    }

    public function toSearchArray(): array
    {
        // Наличие пользовательского метода
        // преобразования модели в поисковый массив
        // позволит нам настраивать данные
        // которые будут доступны для поиска
        // по каждой модели.
        return $this->toArray();
    }
}
