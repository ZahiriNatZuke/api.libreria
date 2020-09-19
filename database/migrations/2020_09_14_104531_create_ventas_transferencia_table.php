<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTransferenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_transferencia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('libro_id');
            $table->string('para');
            $table->integer('cantidad');
            $table->float('precio');
            $table->float('importe')->storedAs('cantidad * precio')->nullable();
            $table->timestamps();
            $table->index('libro_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas_transferencia');
    }
}
