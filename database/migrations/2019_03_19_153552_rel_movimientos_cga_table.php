<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelMovimientosCgaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('REL_MOVIMIENTOS_CGA', function (Blueprint $table) {
            $table->unsignedInteger('FK_MOVIMIENTO');
            $table->foreign('FK_MOVIMIENTO')->references('MOVIMIENTOS_ID')->on('SOLICITUDES_MOVIMIENTOS');
            $table->char('FK_SOLICITUD_ID', 15);
            $table->foreign('FK_SOLICITUD_ID')->references('SOLICITUD_ID')->on('SOLICITUDES_SOLICITUD');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('REL_MOVIMIENTOS_CGA');
    }
}
