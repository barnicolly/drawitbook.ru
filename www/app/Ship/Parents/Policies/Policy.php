<?php

namespace App\Ship\Parents\Policies;

use App\Ship\Parents\Repositories\Repository;

abstract class Policy
{
    public function apply(Repository $repository, $user)
    {
    }
}
