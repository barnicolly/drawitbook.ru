<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class RouterFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'Router';
    }
}
