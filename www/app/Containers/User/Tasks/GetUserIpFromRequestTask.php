<?php

namespace App\Containers\User\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\DB;

class GetUserIpFromRequestTask extends Task
{
    public function run(): string
    {
        $ip = request()->ip();
        return DB::connection()->getPdo()->quote($ip);
    }
}
