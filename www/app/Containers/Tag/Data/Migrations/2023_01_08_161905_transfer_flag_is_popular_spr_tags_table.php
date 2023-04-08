<?php

use App\Containers\Tag\Models\SprTagsModel;
use App\Ship\Enums\FlagsEnum;
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
       $tags = SprTagsModel::where('is_popular', 1)->get();
       if (!blank($tags)) {
           $tags->each(function (SprTagsModel $tag): void {
               $tag->flag(FlagsEnum::TAG_IS_POPULAR);
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
