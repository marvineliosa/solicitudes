<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_LOGIN', function (Blueprint $table) {
            $table->string('LOGIN_USUARIO', 150)->primary();
            $table->string('LOGIN_CONTRASENIA');
            $table->enum('LOGIN_CATEGORIA',['ANALISTA_CGA','ADMINISTRADOR_CGA','COORDINADOR_CGA','TITULAR','TRABAJADOR_SPR','SECRETARIO_PARTICULAR']);
            $table->string('LOGIN_RESPONSABLE')->nullable();
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
        Schema::dropIfExists('SOLICITUDES_LOGIN');
    }
}
