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
        Schema::create('picture_tags', static function (Blueprint $table): void {
            $table->integer('id')->autoIncrement();
            $table->integer('picture_id')->nullable(false)->index();
            $table->integer('tag_id')->nullable(false)->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
