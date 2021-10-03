<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePictureExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createTable();
        $this->dropColumns();
    }

    private function dropColumns()
    {
        $table = 'picture';
        $columns = [
            'path',
            'width',
            'height',
        ];
        foreach ($columns as $column) {
            if (Schema::hasColumn($table, $column)) {
                Schema::dropColumns($table, [$column]);
            }
        }

    }

    private function createTable()
    {
        Schema::create('picture_extensions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('picture_id')->index();
            $table->string('path')->nullable(false);
            $table->integer('width');
            $table->integer('height');
            $table->string('ext');
            $table->tinyInteger('is_del')->index()->default(0)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
