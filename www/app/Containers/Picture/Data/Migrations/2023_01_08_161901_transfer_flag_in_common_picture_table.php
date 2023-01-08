<?php

use App\Containers\Picture\Enums\PictureFlagsEnum;
use App\Containers\Picture\Models\PictureModel;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
       $pictures = PictureModel::where('in_common', 1)->get();
       if (!blank($pictures)) {
            $pictures->each(function (PictureModel $picture) {
                $picture->flag(PictureFlagsEnum::IN_COMMON);
            });
       }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};
