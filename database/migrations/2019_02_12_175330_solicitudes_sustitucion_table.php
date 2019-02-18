<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesSustitucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_SUSTITUCION', function (Blueprint $table) {
            $table->char('FK_SOLICITUD_ID', 15)->primary();
            $table->foreign('FK_SOLICITUD_ID')->references('SOLICITUD_ID')->on('SOLICITUDES_SOLICITUD');
            $table->string('SUSTITUCION_CANDIDATO_NUEVO');
            $table->string('SUSTITUCION_CATEGORIA_NUEVA');
            $table->string('SUSTITUCION_PUESTO_NUEVO');
            $table->text('SUSTITUCION_ACTIVIDADES_NUEVAS');
            $table->integer('SUSTITUCION_SALARIO_NUEVO');
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
        Schema::dropIfExists('SOLICITUDES_SUSTITUCION');
    }
}
