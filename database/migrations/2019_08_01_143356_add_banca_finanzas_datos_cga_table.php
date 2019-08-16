<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBancaFinanzasDatosCgaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("ALTER TABLE SOLICITUDES_DATOS_CGA CHANGE COLUMN DATOS_CGA_ESTATUS DATOS_CGA_ESTATUS ENUM('RECIBIDO SPR','VALIDACIÓN DE INFORMACIÓN','INFORMACIÓN CORRECTA','RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','CANCELADO POR TITULAR','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR','CANCELADO','BANCA Y FINANZAS','BANCA Y FINANZAS COMPLETADO','OTRO') NOT NULL DEFAULT 'RECIBIDO SPR'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("ALTER TABLE SOLICITUDES_DATOS_CGA CHANGE COLUMN DATOS_CGA_ESTATUS DATOS_CGA_ESTATUS ENUM('RECIBIDO SPR','VALIDACIÓN DE INFORMACIÓN','INFORMACIÓN CORRECTA','RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','CANCELADO POR TITULAR','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR','CANCELADO','OTRO') NOT NULL DEFAULT 'RECIBIDO SPR'");
    }
}
