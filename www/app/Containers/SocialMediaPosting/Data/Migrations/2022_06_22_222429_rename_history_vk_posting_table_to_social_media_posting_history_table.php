<?php

declare(strict_types=1);


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('history_vk_posting', 'social_media_posting_history');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
