<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesFirmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_FIRMAS', function (Blueprint $table) {
            $table->increments('FIRMAS_ID');//poniendo increments se da por hecho que es primary
            $table->string('FIRMAS_CGA')->nullable();
            $table->string('FIRMAS_TITULAR')->nullable();
            $table->string('FIRMAS_SPR')->nullable();
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
        Schema::dropIfExists('SOLICITUDES_FIRMAS');
    }
}
