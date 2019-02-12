<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesDependenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_DEPENDENCIA', function (Blueprint $table) {
            $table->increments('DEPENDENCIA_ID');//poniendo increments se da por hecho que es primary
            $table->integer('DEPENDENCIA_CODIGO');
            $table->string('DEPENDENCIA_NOMBRE');
            $table->string('DEPENDENCIA_TITULAR');
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
        Schema::dropIfExists('SOLICITUDES_DEPENDENCIA');
    }
}
