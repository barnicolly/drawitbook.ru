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
        $test =  DB::raw("inet_aton($ip)");
        return $test;
    }

}
