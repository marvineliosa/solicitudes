<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesDatosCgaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_DATOS_CGA', function (Blueprint $table) {
            $table->char('FK_SOLICITUD_ID', 15)->primary();
            $table->foreign('FK_SOLICITUD_ID')->references('SOLICITUD_ID')->on('SOLICITUDES_SOLICITUD');
            $table->enum('DATOS_CGA_ESTATUS',['VALIDACIÓN DE INFORMACIÓN','INFORMACIÓN CORRECTA','RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR','CANCELADO','OTRO']);
            $table->string('DATOS_CGA_PRIORIDAD')->nullable();
            $table->char('DATOS_CGA_PROCEDENTE',5)->nullable();
            $table->char('DATOS_CGA_VALIDACION',15)->nullable();//es el numero de oficio
            $table->integer('DATOS_CGA_SALARIO_PROPUESTO')->nullable();
            $table->string('DATOS_CGA_CATEGORIA_PROPUESTA')->nullable();
            $table->string('DATOS_CGA_PUESTO_PROPUESTO')->nullable();
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
        Schema::dropIfExists('SOLICITUDES_DATOS_CGA');
    }
}
