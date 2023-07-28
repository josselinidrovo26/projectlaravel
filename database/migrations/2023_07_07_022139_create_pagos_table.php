<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->decimal('abono', 8, 2);
            $table->decimal('diferencia', 8, 2);
            $table->string('estado');
            $table->unsignedBigInteger('estudiante_id')->default(0);
            $table->unsignedBigInteger('eventoPago')->default(0);
            $table->timestamps();

            $table->foreign('estudiante_id')->references('id')->on('estudiante');
            $table->foreign('eventoPago')->references('id')->on('blogs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}
