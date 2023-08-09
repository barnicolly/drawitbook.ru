<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('likes')
            ->where('user_id', 0)
            ->update(['user_id' => null]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
