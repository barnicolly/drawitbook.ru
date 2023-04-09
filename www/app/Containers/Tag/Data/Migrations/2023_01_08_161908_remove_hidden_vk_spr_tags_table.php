<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('spr_tags', 'hidden_vk'))
        {
            Schema::table('spr_tags', static function (Blueprint $table) : void {
                $table->dropColumn('hidden_vk');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
