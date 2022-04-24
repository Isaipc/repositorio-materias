<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMateriaIdColumnForArchivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('archivos', function (Blueprint $table) {
            $table->renameColumn('materia_id', 'unidad_id');
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
            $table->renameColumn('unidad_id', 'materia_id');
        });
    }
}
