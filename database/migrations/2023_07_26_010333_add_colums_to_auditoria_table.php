<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsToAuditoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auditoria', function (Blueprint $table) {
            $table->text('codigo');
            $table->text('modulo');
            $table->text('interfaz');
            $table->text('usuario');
            $table->text('sentencia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auditoria', function (Blueprint $table) {
            //
        });
    }
}
