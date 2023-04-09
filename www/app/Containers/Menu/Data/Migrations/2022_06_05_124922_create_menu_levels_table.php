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
        Schema::create('menu_levels', function (Blueprint $table): void {
            $table->id();
            $table->integer('spr_tag_id')->index()->nullable(true);
            $table->integer('parent_level_id')->index()->nullable(true);
            $table->string('custom_name_ru', 255)->index()->nullable(true);
            $table->string('custom_name_en', 255)->index()->nullable(true);
            $table->tinyInteger('show_ru')->default(1)->nullable(false);
            $table->tinyInteger('show_en')->default(1)->nullable(false);
            $table->integer('column')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
