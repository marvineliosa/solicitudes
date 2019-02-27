<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_ARCHIVOS', function (Blueprint $table) {
            $table->increments('ARCHIVOS_ID');
            $table->text('ARCHIVOS_RUTA');
            $table->string('ARCHIVOS_NOMBRE');
            $table->text('ARCHIVOS_MENSAJE')->nullable();
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
        Schema::dropIfExists('SOLICITUDES_ARCHIVOS');
    }
}
