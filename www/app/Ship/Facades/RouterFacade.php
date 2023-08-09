<?php

declare(strict_types=1);

namespace App\Ship\Facades;

use Illuminate\Support\Facades\Facade;
use Router;

class RouterFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Router::class;
    }
}
