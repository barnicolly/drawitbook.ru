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
        Schema::create('user_activity', static function (Blueprint $table): void {
            $table->integer('id')->autoIncrement();
            $table->integer('ip')->unsigned()->index()->nullable(false);
            $table->integer('user_id')->index()->nullable(false);
            $table->integer('picture_id')->index()->nullable(false);
            $table->tinyInteger('activity')->nullable(false)->index();
            $table->timestamps();
            $table->tinyInteger('status')->default(0)->nullable(false)->index();
            $table->tinyInteger('is_del')->default(0)->nullable(false)->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
