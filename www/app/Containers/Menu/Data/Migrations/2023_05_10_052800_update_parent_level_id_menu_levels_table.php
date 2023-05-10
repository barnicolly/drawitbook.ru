<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('menu_levels')->where('parent_level_id', '=', 0)->update(['parent_level_id' => null]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
