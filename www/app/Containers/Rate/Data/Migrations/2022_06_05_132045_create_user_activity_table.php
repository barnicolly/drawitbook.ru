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
        Schema::create('user_activity', function (Blueprint $table): void {
            $table->id();
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
     *
     * @return void
     */
    public function down(): void
    {
    }
};
