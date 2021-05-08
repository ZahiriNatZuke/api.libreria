<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('libro_id');
            $table->enum('accion', ['Entrada', 'Venta', 'Salida']);
            $table->enum('tipo', ['', '', '','', '', '','', '', '','', '', '','', '', '','', '', '','', '', '','', '', '',]);
            $table->float('precio');
            $table->integer('cantidad');
            $table->float('importe')->storedAs('precio * cantidad')->nullable();
            $table->timestamps();
            $table->index(['libro_id', 'accion']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actualizaciones');
    }
}
