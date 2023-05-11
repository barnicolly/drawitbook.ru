<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->removeRelationsWithoutForeignKey();
        foreach (DB::table('picture_tags')->get() as $pictureTag) {
            DB::table('tag_entities')
                ->insert([
                    'tag_id' => $pictureTag->tag_id,
                    'entity_id' => $pictureTag->picture_id,
                    'entity_type' => 'art',
                ]);
        }
    }

    private function removeRelationsWithoutForeignKey(): void
    {
        $results = DB::select(
            (string) DB::raw(
                'select picture_tags.id
             from picture_tags
                      left join tags on picture_tags.tag_id = tags.id
             where tags.id is null',
            )->getValue(DB::connection()->getQueryGrammar()),
        );
        if ($results) {
            foreach ($results as $item) {
                DB::table('picture_tags')->delete($item->id);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
