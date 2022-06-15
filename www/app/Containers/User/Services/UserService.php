<?php

namespace App\Containers\User\Services;

use Illuminate\Support\Facades\DB;

class UserService
{

    public function __construct()
    {
    }

//    todo-misha вынести в таск;
    public function getIp(): string
    {
        $ip = request()->ip();
        return DB::connection()->getPdo()->quote($ip);
    }

}


