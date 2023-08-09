<?php

declare(strict_types=1);

use App\Containers\Picture\Models\PictureModel;
use App\Ship\Enums\FlagsEnum;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $pictures = DB::table('picture')->where('in_common', 1)->get();
        if (!blank($pictures)) {
            $pictures->each(static function (PictureModel $picture): void {
                $picture->flag(FlagsEnum::PICTURE_COMMON);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
