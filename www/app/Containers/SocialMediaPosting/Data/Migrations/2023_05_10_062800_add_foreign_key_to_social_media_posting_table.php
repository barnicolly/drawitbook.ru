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
        Schema::table('social_media_posting_history', static function (Blueprint $table): void {
            $table->foreign('picture_id')->references('id')->on('picture');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
