<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesCambioAdscripcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_CAMBIO_ADSCRIPCION', function (Blueprint $table) {
            $table->string('CAMBIO_ADSCRIPCION_CATEGORIA_NUEVA');
            $table->integer('CAMBIO_ADSCRIPCION_PUESTO_NUEVO');
            $table->text('CAMBIO_ADSCRIPCION_ACTIVIDADES_NUEVAS');
            $table->integer('CAMBIO_ADSCRIPCION_SALARIO_NUEVO');
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
        Schema::dropIfExists('SOLICITUDES_CAMBIO_ADSCRIPCION');
    }
}
