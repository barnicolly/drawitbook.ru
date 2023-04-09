<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vk_album', function (Blueprint $table): void {
            $table->id();
            $table->integer('album_id')->nullable(false)->index();
            $table->string('description', 255)->nullable(false);
            $table->string('share', 255)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
