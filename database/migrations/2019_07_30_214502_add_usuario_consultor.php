<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsuarioConsultor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("ALTER TABLE SOLICITUDES_LOGIN CHANGE COLUMN LOGIN_CATEGORIA LOGIN_CATEGORIA ENUM('ANALISTA_CGA','ADMINISTRADOR_CGA','COORDINADOR_CGA','TITULAR','TRABAJADOR_SPR','SECRETARIO_PARTICULAR','CONSULTOR') NOT NULL DEFAULT 'CONSULTOR'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("ALTER TABLE SOLICITUDES_LOGIN CHANGE COLUMN LOGIN_CATEGORIA LOGIN_CATEGORIA ENUM('ANALISTA_CGA','ADMINISTRADOR_CGA','COORDINADOR_CGA','TITULAR','TRABAJADOR_SPR','SECRETARIO_PARTICULAR') NOT NULL DEFAULT 'CONSULTOR");
    }
}
