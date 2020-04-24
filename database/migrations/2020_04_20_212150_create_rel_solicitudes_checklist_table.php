<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelSolicitudesChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('REL_SOLICITUDES_CHECKLIST', function (Blueprint $table) {
            $table->char('FK_SOLICITUD_ID', 15);
            $table->foreign('FK_SOLICITUD_ID')->references('SOLICITUD_ID')->on('SOLICITUDES_SOLICITUD');
            $table->unsignedInteger('FK_CHECKLIST_ID');
            $table->foreign('FK_CHECKLIST_ID')->references('CHECKLIST_ID')->on('SOLICITUDES_CHECKLIST');
            $table->boolean('REL_CHECK_ADMINISTRADOR')->nullable();
            $table->boolean('REL_CHECK_ANALISTA')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('REL_SOLICITUDES_CHECKLIST');
    }
}
