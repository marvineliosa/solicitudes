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
            $table->char('FK_SOLICITUD_ID', 15)->primary();
            $table->foreign('FK_SOLICITUD_ID')->references('SOLICITUD_ID')->on('SOLICITUDES_SOLICITUD');
            $table->date('FECHAS_CREACION_SOLICITUD');
            $table->date('FECHAS_EXPIRACION')->nullable();
            $table->date('FECHAS_CORRECCION_INFORMACION')->nullable();
            $table->date('FECHAS_INFORMACION_COMPLETA')->nullable();
            $table->date('FECHAS_TURNADO_CGA')->nullable();
            $table->date('FECHAS_RESPUESTA_OFICIO')->nullable();
            $table->date('FECHAS_LEVANTAMIENTO')->nullable();
            $table->date('FECHAS_LIMITE_AGENDAR_CITA')->nullable();
            $table->date('FECHAS_LIMITE_LEVANTAMIENTO')->nullable();
            $table->date('FECHAS_LIMITE_ANALISIS')->nullable();
            $table->date('FECHAS_LIMITE_REVISION')->nullable();
            $table->date('FECHAS_LIMITE_FIRMAS')->nullable();
            $table->date('FECHAS_LIMITE_FINALIZAR')->nullable();
            $table->date('FECHAS_PUESTO_REVISION')->nullable();
            $table->date('FECHAS_PUESTO_FIRMAS')->nullable();
            $table->date('FECHAS_MARCADO_URGENTE')->nullable();
            $table->date('FECHAS_FIRMA_CGA')->nullable();
            $table->date('FECHAS_FIRMA_TITULAR')->nullable();
            $table->date('FECHAS_FIRMA_SPR')->nullable();
            $table->date('FECHAS_TURNADO_SPR')->nullable();
            $table->date('FECHAS_DECISION_SPR')->nullable();
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