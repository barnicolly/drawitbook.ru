<?php

declare(strict_types=1);

namespace App\Containers\Menu\Tests\Traits;

use App\Containers\Menu\Models\MenuLevelsModel;

trait CreateMenuLevelTrait
{
    public function createMenuLevel(array $data = []): MenuLevelsModel
    {
        return MenuLevelsModel::factory()->create($data);
    }
}
