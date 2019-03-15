<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDatosCgaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('SOLICITUDES_DATOS_CGA', function (Blueprint $table) {
            $table->enum('DATOS_CGA_ESTATUS',['RECIBIDO SPR','VALIDACIÓN DE INFORMACIÓN','INFORMACIÓN CORRECTA','RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','CANCELADO POR TITULAR','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR','CANCELADO','OTRO'])->change();
        });//*/
        DB::statement("ALTER TABLE SOLICITUDES_DATOS_CGA CHANGE COLUMN DATOS_CGA_ESTATUS DATOS_CGA_ESTATUS ENUM('RECIBIDO SPR','VALIDACIÓN DE INFORMACIÓN','INFORMACIÓN CORRECTA','RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','CANCELADO POR TITULAR','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR','CANCELADO','OTRO') NOT NULL DEFAULT 'RECIBIDO SPR'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE SOLICITUDES_DATOS_CGA CHANGE COLUMN DATOS_CGA_ESTATUS DATOS_CGA_ESTATUS ENUM('RECIBIDO SPR','VALIDACIÓN DE INFORMACIÓN','INFORMACIÓN CORRECTA','RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISIÓN','FIRMAS','TURNADO A SPR','COMPLETADO POR SPR','COMPLETADO POR RECTOR','CANCELADO','OTRO') NOT NULL DEFAULT 'RECIBIDO SPR'");
    }
}
