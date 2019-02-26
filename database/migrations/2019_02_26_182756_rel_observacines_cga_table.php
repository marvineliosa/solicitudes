<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelObservacinesCgaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('REL_OBSERVACIONES_CGA', function (Blueprint $table) {
            $table->unsignedInteger('FK_OBSERVACION');
            $table->foreign('FK_OBSERVACION')->references('OBSERVACIONES_ID')->on('SOLICITUDES_OBSERVACIONES');
            $table->char('FK_SOLICITUD_ID', 15);
            $table->foreign('FK_SOLICITUD_ID')->references('SOLICITUD_ID')->on('SOLICITUDES_SOLICITUD');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('REL_OBSERVACIONES_CGA');
    }
}
