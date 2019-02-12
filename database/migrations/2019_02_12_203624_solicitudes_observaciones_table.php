<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesObservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_OBSERVACIONES', function (Blueprint $table) {
            $table->increments('OBSERVACIONES_ID');//poniendo increments se da por hecho que es primary
            $table->text('OBSERVACIONES_OBSERVACION');
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
        Schema::dropIfExists('SOLICITUDES_OBSERVACIONES');
    }
}
