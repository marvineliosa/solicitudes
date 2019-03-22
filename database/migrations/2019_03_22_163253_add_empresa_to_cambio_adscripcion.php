<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmpresaToCambioAdscripcion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('SOLICITUDES_CAMBIO_ADSCRIPCION', function (Blueprint $table) {
            $table->string('CAMBIO_ADSCRIPCION_EMPRESA')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('SOLICITUDES_CAMBIO_ADSCRIPCION', function (Blueprint $table) {
            $table->dropColumn('CAMBIO_ADSCRIPCION_EMPRESA');
        });
    }
}
