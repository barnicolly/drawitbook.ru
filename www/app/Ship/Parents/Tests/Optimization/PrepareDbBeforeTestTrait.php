<?php

namespace App\Ship\Parents\Tests\Optimization;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait PrepareDbBeforeTestTrait
{

    protected function truncateTables(): void
    {
        $excludeTables = [
            'migrations',
        ];
        $nonEmptyTables = collect(
            DB::select(
                DB::raw(
                    "SHOW TABLE STATUS WHERE Rows > 0;"
                )
            )
        )
            ->pluck('Name')
            ->toArray();
        if (!empty($nonEmptyTables)) {
            $tableNamesForTruncate = array_diff($nonEmptyTables, $excludeTables);
            if (!empty($tableNamesForTruncate)) {
                $queries = [];
                foreach ($tableNamesForTruncate as $tableName) {
                    $queries[] = 'TRUNCATE TABLE ' . $tableName . ';';
                }
                Schema::disableForeignKeyConstraints();
                DB::unprepared(implode(' ', $queries));
                Schema::enableForeignKeyConstraints();
            }
        }
    }
}
