<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    use HasFactory;
    protected $fillable = [
        'caracteristica_id',
    ];

    public function caracteristica()
{
    return $this->belongsTo(Caracteristica::class);
}
public function prendas()
{
    return $this->hasMany(Prenda::class, 'categoria_producto_id');
}

}
