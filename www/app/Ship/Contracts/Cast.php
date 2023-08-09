<?php

declare(strict_types=1);

namespace App\Ship\Contracts;

interface Cast
{
    /**
     * @return mixed
     */
    public function cast(mixed $value);
}
