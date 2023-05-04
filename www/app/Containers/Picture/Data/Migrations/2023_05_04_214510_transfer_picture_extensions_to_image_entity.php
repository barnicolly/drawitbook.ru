<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (DB::table('picture_extensions')->get() as $pictureExtension) {
            $imageId = DB::table('images')->insertGetId(
                [
                    'path' => $pictureExtension->path,
                    'width' => $pictureExtension->width,
                    'height' => $pictureExtension->height,
                    'ext' => $pictureExtension->ext,
                    'mime_type' => $pictureExtension->mime_type,
                ]
            );
            DB::table('image_entities')
                ->insert([
                    'image_id' => $imageId,
                    'entity_id' => $pictureExtension->picture_id,
                    'entity_type' => 'art',
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
