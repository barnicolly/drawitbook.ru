<?php

declare(strict_types=1);

namespace App\Containers\User\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\DB;

final class GetUserIpFromRequestTask extends Task
{
    public function run(): string
    {
        $ip = request()->ip();
        return DB::connection()->getPdo()->quote($ip);
    }
}
