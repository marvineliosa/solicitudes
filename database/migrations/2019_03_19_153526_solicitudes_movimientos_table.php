<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_MOVIMIENTOS', function (Blueprint $table) {
            $table->increments('MOVIMIENTOS_ID');
            $table->string('MOVIMIENTOS_RESPONSABLE');
            $table->string('MOVIMIENTOS_MOVIMIENTO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SOLICITUDES_MOVIMIENTOS');
    }
}
