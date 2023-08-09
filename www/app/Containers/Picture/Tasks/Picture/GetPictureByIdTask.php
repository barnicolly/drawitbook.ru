<?php

declare(strict_types=1);

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Containers\Picture\Models\PictureModel;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetPictureByIdTask extends Task
{
    /**
     * @throws NotFoundPicture
     */
    public function run(int $id): ?PictureModel
    {
        try {
            return PictureModel::find($id);
        } catch (ModelNotFoundException) {
            throw new NotFoundPicture();
        }
    }
}
