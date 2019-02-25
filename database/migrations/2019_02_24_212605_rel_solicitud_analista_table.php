<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelSolicitudAnalistaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('REL_SOLICITUDES_ANALISTA', function (Blueprint $table) {
            $table->char('FK_SOLICITUD_ID', 15);
            $table->foreign('FK_SOLICITUD_ID')->references('SOLICITUD_ID')->on('SOLICITUDES_SOLICITUD');
            $table->string('FK_USUARIO', 150);
            $table->foreign('FK_USUARIO')->references('LOGIN_USUARIO')->on('SOLICITUDES_LOGIN');
            $table->datetime('FECHA_ASIGNACION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('REL_SOLICITUDES_ANALISTA');
    }
}
