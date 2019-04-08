<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelTitularAvisoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('REL_TITULAR_AVISO', function (Blueprint $table) {
            $table->string('FK_USUARIO', 150);
            $table->foreign('FK_USUARIO')->references('LOGIN_USUARIO')->on('SOLICITUDES_LOGIN');
            $table->integer('FL_AVISO');
            $table->datetime('FECHA_ACEPTACION')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('REL_TITULAR_AVISO');
    }
}
