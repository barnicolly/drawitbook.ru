<?php

use App\Containers\Tag\Enums\SprTagsFlagsEnum;
use App\Containers\Tag\Models\SprTagsModel;
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
           $tags->each(function (SprTagsModel $tag) {
               $tag->flag(SprTagsFlagsEnum::IS_POPULAR);
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
