<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prenda extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'prendas';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'categoria_producto_id',
        'codigo',
        'descripcion',
        'modelo',
        'marca',
        'serie',
        'observaciones',
        'estado',
    ];

    // Relación: Una prenda pertenece a una categoría de producto
    public function categoriaProducto()
    {
        return $this->belongsTo(CategoriaProducto::class, 'categoria_producto_id');
    }

    // Relación: Una prenda puede estar asociada a varios préstamos
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'prendas_id');
    }
}
