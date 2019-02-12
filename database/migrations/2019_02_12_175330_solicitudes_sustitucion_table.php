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
            $table->string('SUSTITUCION_PERSONA_ANTERIOR');
            $table->integer('SUSTITUCION_CATEGORIA_ANTERIOR');
            $table->string('SUSTITUCION_PUESTO_ANTERIOR');
            $table->integer('SUSTITUCION_SALARIO_ANTERIOR');
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
