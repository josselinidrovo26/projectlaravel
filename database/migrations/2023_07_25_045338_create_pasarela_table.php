<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasarelaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasarela', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 8, 2);

            $table->unsignedBigInteger('pasarelapagos')->default(0);
            $table->unsignedBigInteger('pasarelablogs')->default(0);
            $table->timestamps();


     
            $table->foreign('pasarelapagos')->references('id')->on('pagos');
            $table->foreign('pasarelablogs')->references('id')->on('blogs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasarela');
    }
}
