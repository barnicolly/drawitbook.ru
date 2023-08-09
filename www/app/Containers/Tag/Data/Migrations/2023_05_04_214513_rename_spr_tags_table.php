<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('spr_tags', 'tags');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
