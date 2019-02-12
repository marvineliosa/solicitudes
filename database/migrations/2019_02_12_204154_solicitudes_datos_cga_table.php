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
            $table->char('DATOS_CGA_VALIDACION',15);//poniendo increments se da por hecho que es primary
            $table->enum('DATOS_CGA_ESTATUS',['RECIBIDO','LEVANTAMIENTO','ANÁLISIS','REVISION','FIRMAS','ENVIADO','COMPLETADO','CANCELADO','OTRO']);
            $table->string('DATOS_CGA_PRIORIDAD');
            $table->char('DATOS_CGA_PROCEDENTE',5);
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
