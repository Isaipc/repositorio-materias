<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameUrlColumnToArchivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('archivos', function (Blueprint $table) {
            $table->renameColumn('url', 'path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('archivos', function (Blueprint $table) {
            $table->renameColumn('path', 'url');
        });
    }
}
