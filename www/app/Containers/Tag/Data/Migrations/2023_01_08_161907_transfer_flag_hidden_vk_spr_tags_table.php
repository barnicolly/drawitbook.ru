<?php

declare(strict_types=1);

use App\Containers\Tag\Models\TagsModel;
use App\Ship\Enums\FlagsEnum;
use Illuminate\Database\Migrations\Migration;
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tags = DB::table('spr_tags')->where('hidden_vk', 1)->get();
        if (!blank($tags)) {
            $tags->each(static function (TagsModel $tag): void {
                $tag->flag(FlagsEnum::TAG_HIDDEN_VK);
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
