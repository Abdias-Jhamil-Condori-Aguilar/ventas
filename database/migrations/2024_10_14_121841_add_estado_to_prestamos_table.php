<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Verificar si la columna 'estado' ya existe en la tabla 'prestamos'
        if (!Schema::hasColumn('prestamos', 'estado')) {
            Schema::table('prestamos', function (Blueprint $table) {
                $table->string('estado')->default('activo'); // Valor por defecto 'activo'
            });
        }
        
        // Verificar si la columna 'estado' ya existe en la tabla 'prendas'
        if (!Schema::hasColumn('prendas', 'estado')) {
            Schema::table('prendas', function (Blueprint $table) {
                $table->string('estado')->default('activo'); // Valor por defecto 'activo'
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Solo eliminar la columna si existe
        if (Schema::hasColumn('prestamos', 'estado')) {
            Schema::table('prestamos', function (Blueprint $table) {
                $table->dropColumn('estado');
            });
        }

        if (Schema::hasColumn('prendas', 'estado')) {
            Schema::table('prendas', function (Blueprint $table) {
                $table->dropColumn('estado');
            });
        }
    }
};
