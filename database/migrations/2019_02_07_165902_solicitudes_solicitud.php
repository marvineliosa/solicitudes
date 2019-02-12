<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesSolicitud extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_SOLICITUD', function (Blueprint $table) {
            $table->char('SOLICITUD_ID', 15)->primary();
            $table->string('SOLICITUD_OFICIO')->nullable();
            $table->string('SOLICITUD_NOMBRE');
            $table->string('SOLICITUD_CATEGORIA')->nullable();
            $table->string('SOLICITUD_PUESTO');
            $table->text('SOLICITUD_ACTIVIDADES');
            $table->string('SOLICITUD_NOMINA');
            $table->integer('SOLICITUD_SALARIO');
            $table->text('SOLICITUD_JUSTIFICACION');
            $table->string('SOLICITUD_TIPO_SOLICITUD');
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
        Schema::dropIfExists('SOLICITUDES_SOLICITUD');
    }
}
