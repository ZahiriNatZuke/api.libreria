<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefectuososTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defectuosos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('libro_id');
            $table->string('motivo');
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
        Schema::dropIfExists('defectuosos');
    }
}
