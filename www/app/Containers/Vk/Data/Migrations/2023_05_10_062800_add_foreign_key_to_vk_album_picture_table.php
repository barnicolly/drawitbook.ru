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
        Schema::table('vk_album_picture', static function (Blueprint $table): void {
            $table->foreign('vk_album_id')->references('id')->on('vk_album');
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
