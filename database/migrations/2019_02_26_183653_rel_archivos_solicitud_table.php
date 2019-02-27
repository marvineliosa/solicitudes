<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelArchivosSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('REL_ARCHIVOS_SOLICITUD', function (Blueprint $table) {
            $table->unsignedInteger('FK_ARCHIVO');
            $table->foreign('FK_ARCHIVO')->references('ARCHIVOS_ID')->on('SOLICITUDES_ARCHIVOS');
            $table->char('FK_SOLICITUD_ID', 15);
            $table->foreign('FK_SOLICITUD_ID')->references('SOLICITUD_ID')->on('SOLICITUDES_SOLICITUD');
            $table->enum('TIPO_ARCHIVO',['ORGANIGRAMA','PLANTILLA DE PERSONAL','DESCRIPCION DE PUESTO','DESCRIPCION DE PUESTO DESTINO','CURRICULUM','MAPA DE UBICACIÓN','OTRO']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('REL_ARCHIVOS_SOLICITUD');
    }
}
