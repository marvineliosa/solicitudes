<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRelSolicitudesMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('SOLICITUDES_MOVIMIENTOS', function (Blueprint $table) {
            $table->text('MOVIMIENTOS_MOVIMIENTO')->change();
        });//*/
        DB::statement('ALTER TABLE SOLICITUDES_MOVIMIENTOS MODIFY COLUMN MOVIMIENTOS_MOVIMIENTO TEXT');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE SOLICITUDES_MOVIMIENTOS MODIFY COLUMN MOVIMIENTOS_MOVIMIENTO STRING');
    }
}
