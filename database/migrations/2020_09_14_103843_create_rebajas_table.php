<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRebajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rebajas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('libro_id');
            $table->integer('cantidad');
            $table->float('viejo_precio');
            $table->float('nuevo_precio');
            $table->float('viejo_importe')->storedAs('cantidad * viejo_precio')->nullable();
            $table->float('nuevo_importe')->storedAs('cantidad * nuevo_precio')->nullable();
            $table->float('diferencia')->storedAs('nuevo_importe - viejo_importe')->nullable();
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
        Schema::dropIfExists('rebajas');
    }
}
