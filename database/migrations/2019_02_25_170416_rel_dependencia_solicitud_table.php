<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelDependenciaSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('REL_DEPENCENCIA_SOLICITUD', function (Blueprint $table) {
            $table->char('FK_SOLICITUD_ID', 15);
            $table->foreign('FK_SOLICITUD_ID')->references('SOLICITUD_ID')->on('SOLICITUDES_SOLICITUD');
            $table->unsignedInteger('FK_DEPENDENCIA');
            $table->foreign('FK_DEPENDENCIA')->references('DEPENDENCIA_ID')->on('SOLICITUDES_DEPENDENCIA');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('REL_DEPENCENCIA_SOLICITUD');
    }
}
