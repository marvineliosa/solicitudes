<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelDependenciaUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('REL_DEPENCENCIA_TITULAR', function (Blueprint $table) {
            $table->string('FK_USUARIO', 150);
            $table->foreign('FK_USUARIO')->references('LOGIN_USUARIO')->on('SOLICITUDES_LOGIN');
            $table->unsignedInteger('FK_DEPENDENCIA');
            $table->foreign('FK_DEPENDENCIA')->references('DEPENDENCIA_ID')->on('SOLICITUDES_DEPENDENCIA');
            $table->datetime('FECHA_RELACION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('REL_DEPENCENCIA_TITULAR');
    }
}
