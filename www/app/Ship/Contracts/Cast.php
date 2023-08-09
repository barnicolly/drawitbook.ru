<?php

declare(strict_types=1);

namespace App\Ship\Contracts;

interface Cast
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function cast($value);
}
