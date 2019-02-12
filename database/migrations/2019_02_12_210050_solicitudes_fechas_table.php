<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesFechasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_FECHAS', function (Blueprint $table) {
            $table->date('FECHAS_RECIBIDO');
            $table->date('FECHAS_CORRECCION_INFORMACION');
            $table->date('FECHAS_INFORMACION_COMPLETA');
            $table->date('FECHAS_RESPUESTA_OFICIO');
            $table->date('FECHAS_LEVANTAMIENTO');
            $table->date('FECHAS_LIMITE_AGENDAR_CITA');
            $table->date('FECHAS_LIMITE_LEVANTAMIENTO');
            $table->date('FECHAS_LIMITE_ANALISIS');
            $table->date('FECHAS_LIMITE_REVISION');
            $table->date('FECHAS_LIMITE_FIRMAS');
            $table->date('FECHAS_LIMITE_FINALIZAR');
            $table->date('FECHAS_ULTIMO_ENVIO');
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
        Schema::dropIfExists('SOLICITUDES_FECHAS');
    }
}