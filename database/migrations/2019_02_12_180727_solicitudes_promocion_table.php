<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolicitudesPromocionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SOLICITUDES_PROMOCION', function (Blueprint $table) {
            $table->string('PROMOCION_CATEGORIA_SOLICITADA');
            $table->integer('PROMOCION_PUESTO_NUEVO');
            $table->text('PROMOCION_ACTIVIDADES_NUEVAS');
            $table->integer('PROMOCION_SALARIO_NUEVO');
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
        Schema::dropIfExists('SOLICITUDES_PROMOCION');
    }
}