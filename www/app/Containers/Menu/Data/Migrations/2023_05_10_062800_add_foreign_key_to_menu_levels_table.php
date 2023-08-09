<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menu_levels', static function (Blueprint $table): void {
            $table->foreign('spr_tag_id')->references('id')->on('tags');
            $table->foreign('parent_level_id')->references('id')->on('menu_levels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
