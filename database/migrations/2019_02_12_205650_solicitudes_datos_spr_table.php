<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesDatosSprTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_DATOS_SPR', function (Blueprint $table) {
            $table->char('DATOS_SPR_VALIDACION',15);
            $table->integer('DATOS_SPR_SALARIO_INDICADO');
            $table->string('DATOS_SPR_CATEGORIA_AUTORIZADA');
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
        Schema::dropIfExists('SOLICITUDES_DATOS_SPR');
    }
}
