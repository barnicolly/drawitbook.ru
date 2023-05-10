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
        Schema::table('user_claim', static function (Blueprint $table): void {
            $table->bigInteger('user_id')->unsigned()->change();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('reason_id')->references('id')->on('spr_claim_reason');
            $table->foreign('picture_id')->references('id')->on('picture');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
