<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesDiagnosticoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_DIAGNOSTICO', function (Blueprint $table) {
            $table->char('DIAGNOSTICO_OFICIO',15);//poniendo increments se da por hecho que es primary
            $table->date('DIAGNOSTICO_FECHA_ENVIO_OFICIO');
            $table->date('DIAGNOSTICO_FECHA_INFORMACION_COMPLETA');
            $table->date('DIAGNOSTICO_FECHA_ESTABLECIDA');
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
        Schema::dropIfExists('SOLICITUDES_DIAGNOSTICO');
    }
}
