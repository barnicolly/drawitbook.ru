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
        Schema::create('user_claim', static function (Blueprint $table): void {
            $table->integer('id')->autoIncrement();
            $table->integer('user_id')->nullable(true)->index();
            $table->integer('ip')->unsigned()->index()->nullable(false);
            $table->integer('picture_id')->nullable(false)->index();
            $table->integer('reason_id')->nullable(false)->index();
            $table->timestamp('created_at')->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
