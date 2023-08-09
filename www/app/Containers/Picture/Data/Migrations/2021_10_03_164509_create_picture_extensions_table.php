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
        Schema::create('picture_extensions', static function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->integer('picture_id')->index()->nullable(false);
            $table->string('path')->nullable(false);
            $table->integer('width')->nullable(false);
            $table->integer('height')->nullable(false);
            $table->string('ext')->nullable(false);
            $table->tinyInteger('is_del')->index()->default(0)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
