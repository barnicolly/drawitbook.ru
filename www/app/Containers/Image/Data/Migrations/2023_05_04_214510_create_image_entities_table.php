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
        Schema::create('image_entities', static function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('image_id');
            $table->integer('entity_id')->index()->nullable(false);
            $table->string('entity_type')->index()->nullable(false);

            $table->foreign('image_id')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
