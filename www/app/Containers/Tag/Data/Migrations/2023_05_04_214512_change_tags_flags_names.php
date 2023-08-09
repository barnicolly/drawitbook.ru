<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('flags')
            ->where('name', '=', 'spr_tags.hidden')
            ->update(['name' => 'tags_hidden']);
        DB::table('flags')
            ->where('name', '=', 'spr_tags.hidden_vk')
            ->update(['name' => 'tags_hidden_vk']);
        DB::table('flags')
            ->where('name', '=', 'spr_tags.is_popular')
            ->update(['name' => 'tags_is_popular']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
