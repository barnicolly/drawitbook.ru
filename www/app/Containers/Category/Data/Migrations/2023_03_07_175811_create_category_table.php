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
        Schema::create('category', static function (Blueprint $table): void {
            $table->id();
            $table->integer('parent_id')->index()->nullable(true);
            $table->integer('spr_tag_id')->index()->nullable(true);
            $table->string('custom_name_ru', 255)->index()->nullable(true);
            $table->string('custom_name_en', 255)->index()->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
