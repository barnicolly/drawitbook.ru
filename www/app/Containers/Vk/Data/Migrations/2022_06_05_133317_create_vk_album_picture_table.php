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
        Schema::create('vk_album_picture', static function (Blueprint $table): void {
            $table->integer('id')->autoIncrement();
            $table->integer('vk_album_id')->nullable(false)->index();
            $table->integer('picture_id')->nullable(false)->index();
            $table->integer('out_vk_image_id')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
