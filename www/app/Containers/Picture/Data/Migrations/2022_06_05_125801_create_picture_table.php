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
        Schema::create('picture', function (Blueprint $table): void {
            $table->id()->index();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->tinyInteger('is_del')->default(0)->nullable()->index();
            $table->tinyInteger('in_common')->default(0)->nullable()->index();
            $table->tinyInteger('in_vk_posting')->default(0)->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
