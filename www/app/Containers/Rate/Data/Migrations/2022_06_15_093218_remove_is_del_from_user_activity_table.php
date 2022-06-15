<?php

use App\Containers\Rate\Enums\UserActivityColumnsEnum;
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
        if (Schema::hasColumn(UserActivityColumnsEnum::TABlE, 'is_del'))
        {
            Schema::table(UserActivityColumnsEnum::TABlE, function (Blueprint $table)
            {
                $table->dropColumn('is_del');
            });
        }
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
