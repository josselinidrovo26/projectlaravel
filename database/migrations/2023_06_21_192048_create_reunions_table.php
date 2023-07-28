<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReunionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reunions', function (Blueprint $table) {
            $table->id();
            $table->string('tituloreuniones');
            $table->string('descricion');
            $table->text('fechareuniones');
            $table->text('inicio');
            $table->text('fin');
            $table->text('enlace');
            $table->text('participantes');
            $table->text('modonotificar');
            $table->string('tiempo');
            $table->text('horario');
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
        Schema::dropIfExists('reunions');
    }
}
