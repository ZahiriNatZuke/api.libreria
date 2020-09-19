<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('editorial_id');
            $table->string('titulo');
            $table->string('autor')->nullable();
            $table->string('anno')->nullable();
            $table->float('precio');
            $table->integer('cantidad');
            $table->float('importe')->storedAs('precio * cantidad')->nullable();
            $table->enum('categoria', ['Población', 'Ediciones Matanzas', 'Revistas', 'EGREM', 'Misceláneas'])->nullable();
            $table->timestamps();
            $table->index(['editorial_id', 'titulo', 'autor', 'anno', 'categoria']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('libros');
    }
}
