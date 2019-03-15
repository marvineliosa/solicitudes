<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSustitucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('SOLICITUDES_SUSTITUCION', function (Blueprint $table) {
            $table->string('SUSTITUCION_CATEGORIA_NUEVA')->nullable()->change();
            $table->string('SUSTITUCION_PUESTO_NUEVO')->nullable()->change();
        });//*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('SOLICITUDES_SUSTITUCION', function (Blueprint $table) {
            $table->string('SUSTITUCION_CATEGORIA_NUEVA')->change();
            $table->string('SUSTITUCION_PUESTO_NUEVO')->change();
        });//*/
    }
}
