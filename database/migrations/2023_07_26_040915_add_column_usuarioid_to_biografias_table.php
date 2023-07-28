<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUsuarioidToBiografiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('biografias', function (Blueprint $table) {
            $table->unsignedBigInteger('usuarioid')->nullable();

            $table->foreign('usuarioid')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biografias', function (Blueprint $table) {
            //
        });
    }
}
