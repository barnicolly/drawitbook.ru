<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $map = [
            'png' => 'image/png',
            'webp' => 'image/webp',
            'gif' => 'image/gif',
            'jpeg' => 'image/jpeg',
            'bmp' => 'image/bmp',
        ];
        foreach ($map as $extension => $mimeType) {
            $updateData = [
                'mime_type' => $mimeType,
            ];
            DB::table('picture_extensions')->where('ext', $extension)
                ->update($updateData);
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
