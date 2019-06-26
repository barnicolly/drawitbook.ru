<?php

namespace App\UseCases\User;

use Illuminate\Support\Facades\DB;

class GetIp
{

    private $_ip;

    public function __construct(string $ip)
    {
        $this->_ip = $ip;
    }

    public function clean()
    {
        return DB::connection()->getPdo()->quote($this->_ip);
    }

    public function inetAton()
    {
        $ip = $this->clean();
        return DB::raw("inet_aton($ip)");
    }

}
