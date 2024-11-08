<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_producto_id'); // Relación con la tabla categorias
            $table->string('codigo');
            $table->string('descripcion');
            $table->string('modelo')->nullable();
            $table->string('marca')->nullable();
            $table->string('serie')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('estado')->default('disponible');
            $table->timestamps();

            // Llave foránea
            $table->foreign('categoria_producto_id')->references('id')->on('categoria_productos')->onDelete('cascade');
  
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prendas');
    }
};
