<?php

use App\Containers\Tag\Models\SprTagsModel;
use App\Ship\Enums\FlagsEnum;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       $tags = SprTagsModel::where('hidden', 1)->get();
       if (!blank($tags)) {
           $tags->each(static function (SprTagsModel $tag) : void {
               $tag->flag(FlagsEnum::TAG_HIDDEN);
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
