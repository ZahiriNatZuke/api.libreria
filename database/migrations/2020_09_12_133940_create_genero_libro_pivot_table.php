<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneroLibroPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genero_libro', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('genero_id');
            $table->unsignedBigInteger('libro_id');
            $table->index(['genero_id', 'libro_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genero_libro');
    }
}
