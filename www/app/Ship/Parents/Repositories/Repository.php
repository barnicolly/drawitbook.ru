<?php

declare(strict_types=1);

namespace App\Ship\Parents\Repositories;

use Prettus\Repository\Eloquent\BaseRepository as AbstractRepository;

abstract class Repository extends AbstractRepository
{
    public function resetModel(): void
    {
        $this->makeModel();
        /**
         * Сброс критериев при вызове через service container laravel, чтобы не накапливались при повторном вызове репозитория
         */
        $this->resetCriteria();
    }
}
