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
        Schema::create('spr_tags', static function (Blueprint $table): void {
            $table->integer('id')->autoIncrement();
            $table->string('name', 255)->index()->nullable(false);
            $table->string('name_en', 255)->nullable(true);
            $table->tinyInteger('hidden')->nullable(false)->default(0);
            $table->tinyInteger('hidden_vk')->nullable(false)->default(0);
            $table->string('seo', 255)->nullable(false)->unique();
            $table->string('slug_en', 255)->nullable(true)->unique();
            $table->tinyInteger('is_popular')->nullable(false)->default(0)->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
