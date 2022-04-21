<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('monto');
            $table->string('codigo_seguridad');
            $table->string('comercio_rut',10);
            $table->foreignId('dispositivo_id');
            $table->foreign('comercio_rut')->references('rut')->on('comercios');
            $table->foreign('dispositivo_id')->references('id')->on('dispositivos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};
