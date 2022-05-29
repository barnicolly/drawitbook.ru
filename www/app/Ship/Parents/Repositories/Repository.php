<?php

namespace App\Ship\Parents\Repositories;

use App\Ship\Parents\Policies\Policy;
use Prettus\Repository\Eloquent\BaseRepository as AbstractRepository;

abstract class Repository extends AbstractRepository
{

    public function setPolicy($policy, ...$args)
    {
        if (is_string($policy)) {
            $policy = new $policy($args);
        }

        if (!($policy instanceof Policy)) {
            return;
        }
        /** @var Policy $policy */
        return $policy->apply($this, $this->user, $args);
    }

}
