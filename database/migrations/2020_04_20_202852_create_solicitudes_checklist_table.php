<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_CHECKLIST', function (Blueprint $table) {
            $table->increments('CHECKLIST_ID');
            $table->string('CHECKLIST_CONCEPTO');
            $table->boolean('CHECKLIST_IMPORTANTE')->nullable();
            $table->boolean('CHECKLIST_ACTIVO');
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
        Schema::dropIfExists('SOLICITUDES_CHECKLIST');
    }
}
