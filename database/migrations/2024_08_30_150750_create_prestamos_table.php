<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id'); // Relación con la tabla clientes
            $table->unsignedBigInteger('intere_id'); // Relación con la tabla de intereses
            $table->unsignedBigInteger('prendas_id'); // Relación con la tabla prendas
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('monto', 10, 2);
            $table->integer('meses');
            $table->decimal('interes_calculado', 10, 2);
            $table->decimal('total_pagar', 10, 2);
            $table->string('estado')->default('activo');
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('intere_id')->references('id')->on('interes')->onDelete('cascade');
            $table->foreign('prendas_id')->references('id')->on('prendas')->onDelete('cascade');
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prestamos');
    }
}
