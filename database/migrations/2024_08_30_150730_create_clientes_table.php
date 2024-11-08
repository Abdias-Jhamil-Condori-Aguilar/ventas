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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('papellido', 255);
            $table->string('sapellido', 255);
            $table->date('fecha_nacimiento');
            $table->string('correo_electronico', 255)->unique()->nullable();
            $table->string('telefono', 15)->unique();
            $table->string('domicilio', 255);
            $table->string('ciudad', 100);
            
            // Definir la columna antes de la clave foránea
            $table->unsignedBigInteger('tipo_documento_id')->nullable();
            
            // Establecer la clave foránea
            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documentos')->onDelete('set null');
            
            $table->string('numero_identificacion', 20)->unique();
            $table->tinyInteger('estado')->default(1);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};

