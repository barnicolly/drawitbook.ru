<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->index()->nullable(true);
            $table->integer('spr_tag_id')->index()->nullable(true);
            $table->string('custom_name_ru', 255)->index()->nullable(true);
            $table->string('custom_name_en', 255)->index()->nullable(true);
            $table->boolean('show_ru')->default(true)->nullable(false);
            $table->boolean('show_en')->default(true)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};
